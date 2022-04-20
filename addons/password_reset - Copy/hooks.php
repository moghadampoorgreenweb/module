<?php
include __DIR__ . "/Helper/Helper.php";
include __DIR__ . "/vendor/autoload.php";
include __DIR__ . "/Model/Model.php";

use Carbon\Carbon;

$helper = new \password_reset\Helper\Helper();
$model = new \password_reset\Model\Model();


add_hook('ClientAreaPage', 1, function ($vars) use ($helper,$model) {
    $results = $helper->getClientsDetails($vars['client']['id']);
    $created_at = $vars['clientsdetails']['model']['created_at'];
    $tblclient = $model->select($vars['client']['id']);
    $passwordexpired_at = $tblclient->pwresetexpiry == "0000-00-00 00:00:00" ? null : $tblclient->pwresetexpiry;
    $helper->ifTheUserDoesNotResetThePasswordForTheLoad($created_at, $passwordexpired_at, $results);
    $passwordexpired_at = Carbon::parse($passwordexpired_at)->diffInDays();
    $helper->ifTheUserDoesNotResetThePassword($passwordexpired_at, $results);
});


add_hook('UserChangePassword', 1, function ($vars)use ($model) {
    $model-> updateExpiredPassword($vars['userid']);
});