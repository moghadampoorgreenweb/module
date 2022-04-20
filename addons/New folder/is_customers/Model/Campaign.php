<?php

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as Capsule;


class Campaign
{

    public function tableExist($table)
    {
      return  Capsule::table($table);
    }

    public function modifyActiveTokenCampainWhere($email,$code,$array)
    {
     return   Capsule::table('campaign')
            ->where('email', $email)
            ->where('code', $code)
            ->update($array);
    }

    public function getCampaign($request): \Illuminate\Support\Collection
    {
        $token = Capsule::table('campaign')->where('email', $request)->get();
        return $token;
    }


    public function generateCode($email, float $code)
    {
        try {

            $result = Capsule::table('campaign')->insert([
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