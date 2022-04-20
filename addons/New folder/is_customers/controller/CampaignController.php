<?php
include __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/../Service/EmailService/EmailService.php';
include __DIR__ . '/../Model/Campaign.php';

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Database\Capsule\Manager as Capsule;
use Respect\Validation\Validator as v;

const NUMBER_OFTOKENS_ALLOWED = 100;
const EXPIRED_TOKEN_MINUTE = 1;
const TRIES_TOKEN = 3;


class CampaignController extends mainController
{

    private EmailService $emailService;
    private Campaign $model;

    public function __construct()
    {
        $this->emailService = new EmailService();
        $this->model = new Campaign();
    }

    public function register()
    {
        echo 'Campaign';
        $request = $_POST['email'];

        $campaign = $this->model->getCampaign($request);
        $this->checkCountToken($campaign);
        $CampaignaActiveToken = $this->getCampaignaActiveToken($campaign);
        $this->checkActiveToken($CampaignaActiveToken);
        $validate = $this->validateEmail($request);
        if (!$validate) {

            var_dump(false);
            die;
        }
        $client = $this->chechNotEqualClient($request);
        $code = $this->checkTokenDublicate($campaign);
        $this->checkTokenGenerate($client['email'], $code);
        var_dump($this->emailService->emailApi($client['id'], $code));
        die;
    }


    public function checktoken()
    {
        $request = $_POST['email'];
        $code = $_POST['code'];
        $campaign = $this->model->getCampaign($request);
        $validate = $this->validateEmail($request);
        if (!$validate) {

            var_dump(false);
            die;
        }
        $client = $this->chechNotEqualClient($request);
        $CampaignaActiveToken = $this->checkNotEqualActiveToken($campaign);
        $this->chechNotEqualCode($CampaignaActiveToken, $code, $campaign, $client['email']);
        $this->model->modifyActiveTokenCampainWhere($client['email'], $CampaignaActiveToken, ['verifed_at' => Carbon::now()]);
        echo Carbon::parse($client['datecreated'])->diffInDays();
        die;
    }


    /**
     * @param \Illuminate\Support\Collection $token
     * @param float $code
     * @return bool
     */
    public function isTokensForuser(\Illuminate\Support\Collection $token, float $code): bool
    {
        return !is_null($token->where('code', $code)->first());
    }


    /**
     * @return
     */
    public function validateEmail($request): bool
    {
        return v::email()->validate($request);

    }

    /**
     * @return float
     */
    public function getCode(): float
    {
        $code = round(rand(1000, 9999), 10);
        return $code;
    }

    public function getClient($email)
    {

        $command = 'GetClients';
        $postData = array(
            'search' => $email,
        );
        $results = localAPI($command, $postData);
        if (empty($results['result']) && is_null($results['result'])) {

            return false;
        }
        if ($results['totalresults'] == 0) {

            return false;
        }

        return $results['clients']['client'][0];
    }

    /**
     * @param \Illuminate\Support\Collection $campaign
     * @return \Illuminate\Support\Collection
     */
    public function hasTeknExpired(\Illuminate\Support\Collection $campaign): \Illuminate\Support\Collection
    {
        return $campaign->map(function ($item) {
            return $item > Carbon::now();
        });

    }


    public function getCampaignaActiveToken(\Illuminate\Support\Collection $campaign)
    {
        $pluckCampaign = $campaign->pluck('expired_at', 'code');
        $checkCodeDublicate = $this->hasTeknExpired($pluckCampaign);
        $CampaignaArrayToken = $checkCodeDublicate->toArray();
        $CampaignaActiveToken = array_search('true', $CampaignaArrayToken);
        return $CampaignaActiveToken;
    }

    /**
     * @param int $tries
     * @return void
     */
    private function checkTries(int $tries): void
    {
        if ($tries > TRIES_TOKEN) {
            var_dump('tries max plese wait');
            die;
        }
    }

    /**
     * @param int|string $CampaignaActiveToken
     * @param mixed $code
     * @param \Illuminate\Support\Collection $campaign
     * @param $email
     * @return void
     */
    private function chechNotEqualCode($CampaignaActiveToken, $code, \Illuminate\Support\Collection $campaign, $email)
    {
        if ($CampaignaActiveToken != $code) {
            var_dump('token not equal');
            $trie = $campaign->where('code', $CampaignaActiveToken)->first();
            $tries = is_null($trie->tries) ? 1 : $trie->tries + 1;
            $this->checkTries($tries);
            $this->model->modifyActiveTokenCampainWhere($email, $CampaignaActiveToken, ['tries' => $tries]);
            return die;
        }
    }

    /**
     * @param \Illuminate\Support\Collection $campaign
     * @return int|string|void
     */
    private function checkNotEqualActiveToken(\Illuminate\Support\Collection $campaign)
    {
        $CampaignaActiveToken = $this->getCampaignaActiveToken($campaign);
        if (!$CampaignaActiveToken) {

            var_dump('token  expired');
            return die;
        }
        return $CampaignaActiveToken;
    }

    /**
     * @param mixed $request
     * @return mixed|void
     */
    private function chechNotEqualClient($request)
    {
        $client = $this->getClient($request);
        if (!$client) {

            var_dump(false);
            return die;
        }
        return $client;
    }


    private function requestMethod($method)
    {
        if ($_POST["REQUEST_METHOD"] != $method) {

            var_dump('request not found');
            return die;
        }
    }


    private function checkCountToken(\Illuminate\Support\Collection $campaign)
    {
        if (!($campaign->count() < NUMBER_OFTOKENS_ALLOWED)) {

            var_dump(false);
            return die;
        }
    }

    /**
     * @param bool|int|string $CampaignaActiveToken
     * @return void
     */
    private function checkActiveToken($CampaignaActiveToken)
    {
        if ($CampaignaActiveToken) {

            var_dump('token not expired');
            return die;
        }
    }

    /**
     * @param $email
     * @param float $code
     *
     */
    private function checkTokenGenerate($email, float $code)
    {

        $resultDatabase = $this->model->generateCode($email, $code);
        if (!$resultDatabase) {

            var_dump('Token not created.');
            return die;
        }
    }

    /**
     * @param \Illuminate\Support\Collection $campaign
     *
     */
    private function checkTokenDublicate(\Illuminate\Support\Collection $campaign)
    {
        $code = $this->getCode();
        if ($this->isTokensForuser($campaign, $code)) {
            $code = $this->getCode();
        }
        return $code;
    }

}