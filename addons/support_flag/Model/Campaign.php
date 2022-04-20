<?php
include __DIR__."/../Configuration/Config.php";
use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as Capsule;

class Campaign extends \Illuminate\Database\Eloquent\Model
{
    protected $table='Campaign';

    public function modifyActiveTokenCampainWhere($email,$code,$array)
    {

     return   Capsule::table('campaign')
            ->where('email', $email)
            ->where('code', $code)
            ->update($array);
    }

    public function getCampaign($request): \Illuminate\Support\Collection
    {
        $token = $this->all()->where('email', $request);
        return $token;
    }


    public function generateCode($email, float $code)
    {
        try {
            $result = $this->insert([
                'email' => $email,
                'code' => $code,
                'expired_at' => Carbon::now()->addMinutes(Configuration::EXPIRED_TOKEN_MINUTE),
                'created_at' => Carbon::now()->toDate(),
            ]);

            file_put_contents(__DIR__ . '/test.txt', $result);
            return $result;
        } catch (Exception $e) {
            file_put_contents(__DIR__ . '/test.txt', $e);
            return $e;
        }
    }

}