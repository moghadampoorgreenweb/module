<?php
/**
 * Created by PhpStorm.
 * User: m.farzaneh
 * Date: 4/28/2018
 * Time: 11:42 AM
 */
use \Illuminate\Database\Capsule\Manager as Capsule;

class customers extends mainController
{

    public function index()
    {
        $pid = (isset($_GET['pid'])) ? $_GET['pid'] : false;
        if (!$pid) {
            echo 'لینک خراب است.';
            return false;
        }
        $results = Capsule::table('tblhosting')
            ->leftJoin('tblclients','tblhosting.userid','=','tblclients.id')
            ->where('tblhosting.packageid','=',$pid)
            ->get();
        if ($results){
            $this->render('customers',compact('results','pid'));
        }
    }

    public function export()
    {
        $pid = (isset($_GET['pid'])) ? $_GET['pid'] : false;
        if (!$pid) {
            echo 'لینک خراب است.';
            return false;
        }
        $results = Capsule::table('tblhosting')
            ->leftJoin('tblclients','tblhosting.userid','=','tblclients.id')
            ->where('tblhosting.packageid','=',$pid)
            ->get();
        ob_start();
        $arr = array();
        foreach ($results as $item){
            if (!empty($item->address2)){
                if (!in_array($item->userid,$arr)) {
                    if (preg_match("/(?:09|\+?63)(?:\d(?:-)?){9,10}/", $item->address2,$matches)) {

                        // valid mobile number
                        echo $matches[0] .'
';
                    }
//                    echo rtrim($item->address2, ' ') . "
//";
                }
            }
            $arr[] = $item->userid;
        }
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=export_numbers.txt');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        readfile('export_numbers.txt');
        exit;

    }

}