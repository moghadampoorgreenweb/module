<?php

namespace password_reset\Model;

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as Capsule;

class Model extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'tblclients';


    public function select($userId){
     return   $this->all()->where('id', $userId)->first();
    }

    public function updateExpiredPassword($userId)
    {
        Capsule::table('tblclients')
            ->where('id', $userId)
            ->update([
                'pwresetexpiry' => Carbon::now()
            ]);
    }

}