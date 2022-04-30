<?php

namespace tiket_module\Models;

use    Illuminate\Database\Capsule\Manager as Capsule;
use Punic\Exception;

class Admin extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'admin_weight';


    public function getAll()
    {

        return Capsule::table('admin_weight')->get();
    }

    public function create($data)
    {

        return Capsule::table('admin_weight')->insert($data);
    }


}