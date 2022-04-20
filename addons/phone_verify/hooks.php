<?php
use Illuminate\Database\Capsule\Manager as Capsule;


add_hook('ClientAreaPage', 1, function ($vars) {

    $postData = [
        'clientid' => $vars['client']['id'],
        'stats' => true,
    ];
    $results = localAPI('GetClientsDetails', $postData);


     $data= Capsule::table('phone')->first();
        if ($data->is_active==1){
            if (isset($_SESSION['uid'])){
                if ($_SERVER['REQUEST_URI'] != '/whm/index.php?rp=/user/password' && $_SERVER['REQUEST_URI'] != '/whm/index.php?rp=/login' && $_SERVER['REQUEST_URI'] != '/whm/index.php' ) {
//      if ($vars['currentpagelinkback']){
                    if (!$results['customfields1'] == 'on') {
                        file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . 'file.json', json_encode($results));
                        header('Location: http://localhost/whm/index.php?m=phone_verify');
                        exit();
                    }
                }
            }
        }


//    file_put_contents(__DIR__ . '/text.json', json_encode($data->is_active), FILE_APPEND);

});

//add_hook('UserLogin', 1, function ($vars) {
//
//    $postData = [
//        'clientid' => $vars['user']['id'],
//        'stats' => true,
//    ];
//    $results = localAPI('GetClientsDetails', $postData);
//
//
////      if ($vars['currentpagelinkback']){
//        if (! $results['customfields1'] == 'on') {
//            file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . 'file.json', json_encode($results));
//            header('Location: http://localhost/whm/index.php?m=phone_verify');
//            exit();
//        }
//
//
//    file_put_contents(__DIR__ . '/text.json', json_encode($vars), FILE_APPEND);
//});