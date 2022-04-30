<?php

header("Access-Control-Allow-Origin: https://iranserver.com");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, *");

use Illuminate\Database\Capsule\Manager as Capsule;

require_once __DIR__ . '/../../../../init.php';

if($_SERVER['HTTP_HOST'] !='iranserver.com' and 0){
    exit('permission Forbidden');
}
if(!$_GET['email']){
    echo json_encode('پارامتر ایمیل الزامی میباشد');
    die;
}
$email=$_GET['email'];
/*
|--------------------------------------------------------------------------
| Get Count Days Login
|--------------------------------------------------------------------------
*/
$user=Capsule::table('tblclients')->where('email',$email)->first('dateCreated');
$date1 = new DateTime($user->dateCreated);
$date2 = new DateTime(date('Y-m-d'));
$days = $date1->diff($date2);

$result=[
    'data'=>[
        'dateCreated'=>$user->dateCreated,
        'countDay'=>$days->days
    ]
];

echo json_encode($result);
die;