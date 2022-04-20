<?php
include __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/../Service/EmailService/EmailService.php';
include __DIR__ . '/../Model/Campaign.php';
include __DIR__ . '/../Response/Response.php';
include __DIR__ . '/../Request/Request.php';
include __DIR__ . '/../Helper/Helper.php';


use Carbon\Carbon;


class CampaignController extends mainController
{

    private EmailService $emailService;
    private Campaign $model;
    private Request $request;
    private Helper $helper;

    public function __construct()
    {
        $this->emailService = new EmailService();
        $this->model = new Campaign();
        $this->request = new Request();
        $this->helper = new Helper();
    }

    public function register()
    {
        $this->helper->requestMethod("POST");
        $email = $_POST['email'];
        $this->requiredEmail($email);
        $campaign = $this->model->getCampaign($email);
        $this->checkCountToken($campaign);
        $CampaignaActiveToken = $this->getCampaignaActiveToken($campaign);
        $this->checkActiveToken($CampaignaActiveToken);
        $this->emailValidate($email);
        $client = $this->chechNotEqualClient($email);
        $code = $this->checkTokenDublicate($campaign);
        $this->checkTokenGenerate($client['email'], $code);
        Response::success(201, $this->emailService->emailApi($client['id'], $code));
        die;
    }


    public function checktoken()
    {
        $this->helper->requestMethod("GET");
        $email = $_GET['email'];
        $code = $_GET['code'];
        $this->required($email, $code);
        $campaign = $this->model->getCampaign($email);
        $this->emailValidate($email);
        $client = $this->chechNotEqualClient($email);
        $CampaignaActiveToken = $this->checkNotEqualActiveToken($campaign);
        $this->chechNotEqualCode($CampaignaActiveToken, $code, $campaign, $client['email']);
        $this->model->modifyActiveTokenCampainWhere($client['email'], $CampaignaActiveToken, ['verifed_at' => Carbon::now()]);
        Response::success(200,Carbon::parse($client['datecreated'])->diffInDays());
        die;
    }


    /**
     * @param \Illuminate\Support\Collection $token
     * @param float $code
     * @return bool
     */
    public function isTokensForuser(\Illuminate\Support\Collection $token, $code)
    {
        return !is_null($token->where('code', $code)->first());
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


    private function checkTries($tries)
    {
        if ($tries > Configuration::TRIES_TOKEN) {
            Response::errore(400, 'The number of times allowed is over. Please wait a moment and get the token again.');
            die;
        }
    }


    private function chechNotEqualCode($CampaignaActiveToken, $code, $campaign, $email)
    {
        if ($CampaignaActiveToken != $code) {
            $trie = $campaign->where('code', $CampaignaActiveToken)->first();
            $tries = is_null($trie->tries) ? 1 : $trie->tries + 1;
            $this->checkTries($tries);
            $this->model->modifyActiveTokenCampainWhere($email, $CampaignaActiveToken, ['tries' => $tries]);
            Response::errore(400, 'token not equal.');
            die;
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
            Response::errore(400, 'token  expired');
            die;
        }
        return $CampaignaActiveToken;
    }

    /**
     * @param mixed $request
     * @return mixed|void
     */
    private function chechNotEqualClient($request)
    {
        $client = $this->helper->getClient($request);
        if (!$client) {
            Response::errore(400, 'client not found.');
            die;
        }
        return $client;
    }





    private function checkCountToken(\Illuminate\Support\Collection $campaign)
    {
        if (!($campaign->count() < Configuration::NUMBER_OFTOKENS_ALLOWED)) {
            Response::errore(406, 'The number of times allowed has expired.');
            die;
        }
    }

    /**
     * @param bool|int|string $CampaignaActiveToken
     * @return void
     */
    private function checkActiveToken($CampaignaActiveToken)
    {
        if ($CampaignaActiveToken) {
            Response::errore(406, 'Token not expired.');
            die;
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
            Response::errore(406, 'No token created.');
            die;
        }
    }

    /**
     * @param \Illuminate\Support\Collection $campaign
     *
     */
    private function checkTokenDublicate(\Illuminate\Support\Collection $campaign)
    {
        $code = $this->helper->getCode();
        if ($this->isTokensForuser($campaign, $code)) {
            $code = $this->helper->getCode();
        }
        return $code;
    }

    /**
     * @param mixed $request
     * @param mixed $code
     * @return void
     */
    private function required($email, $code)
    {
        $this->requiredEmail($email);
        if ($this->request->validate($code)) {
            Response::errore(422, 'code is required.');
            die;
        }
    }

    /**
     * @param mixed $email
     * @return void
     */
    private function emailValidate($email)
    {
        $validate = $this->helper->validateEmail($email);
        if (!$validate) {
            Response::errore(404, 'user not found.');
            die;
        }
    }

    /**
     * @param mixed $email
     * @return void
     */
    private function requiredEmail($email)
    {
        if ($this->request->validate($email)) {
            Response::errore(422, 'email is required.');
            die;
        }
    }

}