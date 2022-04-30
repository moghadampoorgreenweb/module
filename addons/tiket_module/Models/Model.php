<?php

namespace tiket_module\Models;

use    Illuminate\Database\Capsule\Manager as Capsule;
use Punic\Exception;

class Model extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'tiket_module';


    public function getAll()
    {

        return Capsule::table('tiket_module')->get();
    }

    public function create($data)
    {

        return Capsule::table('tiket_module')->insert($data);
    }


    public function updates($ticketId,$adminId)
    {

        Capsule::table('tiket_module')->get()->where('ticket_id','=',$ticketId)->update([
           'admin_id'=>$adminId,
        ]);
    }


    /**
     * @param $data
     * @param $idTblPricing
     * @return array
     */
    public function checkZero($data, $idTblPricing)
    {
        foreach ($data as $key => $value) {
            if ($value > 0) {
                $out['id'] = $idTblPricing;
                $out[$key] = $value;
            } else {
                unset($data[$key]);
            }
        }
        return array($value, $out);
    }


}