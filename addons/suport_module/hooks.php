<?php
include __DIR__ . "/Models/Model.php";
$model=new Model();



add_hook('AdminAreaViewTicketPage', 1, function ($vars) use($model) {


    ob_start();
    include __DIR__."/view.php";
    $output=ob_get_contents();
    ob_end_clean();

    $model->createOrUpdate($vars['ticketid'],$_REQUEST['selectBox']);
    file_put_contents(__DIR__ . "/text.txt", json_encode($_REQUEST));

    return $output;

});

