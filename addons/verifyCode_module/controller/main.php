<?php
/**
 * Created by PhpStorm.
 * User: m.farzaneh
 * Date: 4/28/2018
 * Time: 11:42 AM
 */
use \Illuminate\Database\Capsule\Manager as Capsule;
class main extends mainController
{

    public function index()
    {
        $results = Capsule::table('tblproducts')->leftJoin('tblproductgroups','tblproductgroups.id','=','tblproducts.gid')->select('tblproducts.name AS prName','tblproductgroups.name AS gpName','tblproducts.id AS prId')->get();
        $this->render('index', compact('results'));
    }

    public function customers()
    {

    }
}