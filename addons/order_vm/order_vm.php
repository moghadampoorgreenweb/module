<?php

include_once __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/Models/Model.php';
include_once __DIR__ . '/Controllers/ModuleController.php';
include_once __DIR__ . '/Helpers/HelperModule.php';
include_once __DIR__ . '/Response/Response.php';


if (!defined("WHMCS"))
    die("This file cannot be accessed directly");


use Illuminate\Database\Capsule\Manager as Capsule;


function order_vm_config()
{
    $configarray = array(
        "name" => "order_vm",
        "description" => "This is a sample config function for an addon module",
        "version" => "1.0",
        "author" => "WHMCS",
        "fields" => array(
            "token" => array("FriendlyName" => "token", "Type" => "text", "Size" => "25",
                "Description" => "Textbox", "Default" => "Example",),
            "phone" => array("FriendlyName" => "phone", "Type" => "text", "Size" => "25",
                "Description" => "Textbox", "Default" => "Example",),
            "option5" => array("FriendlyName" => "Option5", "Type" => "radio", "Options" =>
                "Demo1,Demo2,Demo3", "Description" => "Radio Options Demo",),
        ));
    return $configarray;
}


function order_vm_activate()
{
    // Create custom tables and schema required by your module
    try {
        $table = Capsule::table('order_vm');
        if ($table) {
            Capsule::schema()
                ->create(
                    'order_vm',
                    function ($table) {
                        /** @var \Illuminate\Database\Schema\Blueprint $table */
                        $table->increments('id');
                        $table->integer('user_id');
                        $table->text('body');
                        $table->string('phone');
                        $table->string('status');
                        $table->timestamps();
                    }
                );
        }
        Capsule::table('order_vm')->insert([
            'user_id' => 1,
            'body' => 'amirrza',
            'phone' => '09354114548',
            'status' => 'pending',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        return [
            // Supported values here include: success, error or info
            'status' => 'success',
            'description' => 'This is a demo module only. '
                . 'In a real module you might report a success or instruct a '
                . 'user how to get started with it here.',
        ];
    } catch (\Exception $e) {
        return [
            // Supported values here include: success, error or info
            'status' => "error",
            'description' => 'Unable to create mod_addonexample: ' . $e->getMessage(),
        ];
    }
}


function order_vm_deactivate()
{
    // Undo any database and schema modifications made by your module here
    try {
        Capsule::schema()
            ->dropIfExists('order_vm');
        return [
            // Supported values here include: success, error or info
            'status' => 'success',
            'description' => 'This is a demo module only. '
                . 'In a real module you might report a success here.',
        ];
    } catch (\Exception $e) {
        return [
            // Supported values here include: success, error or info
            "status" => "error",
            "description" => "Unable to drop mod_addonexample: {$e->getMessage()}",
        ];
    }
}


function order_vm_output($vars)
{

}


function order_vm_clientarea($vars)
{
    $controller = new \order_vm\Controllers\ModuleController($_REQUEST);
    $region = \order_vm\Response\Response::serverRegion();
    $opratingsystem = \order_vm\Response\Response::opratingSystem();
    $space = \order_vm\Response\Response::space();

    $planwhere = \order_vm\Response\Response::wherePlan($_REQUEST['region'], $_REQUEST['disk'], $_REQUEST['opratingsystem']);
    $plan = \order_vm\Response\Response::serverPlan();
    if (isset($_GET['action']) && $_GET['action'] === 'region' && isset($_GET['region'])){
        file_put_contents(__DIR__.'/tx.txt','ok');
        $id = $_GET['region'];
        $os = $opratingsystem->filter(function ($item) use ($id) {
            return $item['region']['id'] == $id;
        })->values()->toArray();
        http_response_code(200);
        echo json_encode($os);
        die;
    }
    if (isset($_GET['action']) && $_GET['action'] === 'os' && isset($_GET['region'])){
        file_put_contents(__DIR__.'/tx.txt','ok');
        $id = $_GET['region'];
        $os = $space->filter(function ($item) use ($id) {
            return $item['opratingSystem']['id'] == $id;
        })->values()->toArray();
        http_response_code(200);
        echo json_encode($os);
        die;
    }
    if (isset($_GET['action']) && $_GET['action'] === 'disk' && isset($_GET['region'])){
        file_put_contents(__DIR__.'/tx.txt','ok');
        $id = $_GET['region'];
        $os = $space->filter(function ($item) use ($id) {
            return $item['opratingSystem']['id'] == $id;
        })->values()->toArray();
        http_response_code(200);
        echo json_encode($os);
        die;
    }
    if (isset($_GET['action']) && $_GET['action'] === 'plan' && isset($_GET['region'])){
        file_put_contents(__DIR__.'/tx.txt','ok');
        $id = $_GET['region'];
        $os = $plan->filter(function ($item) use ($id) {
            return $item['spase']['id'] == $id;
        })->values()->toArray();
        http_response_code(200);
        echo json_encode($os);
        die;
    }
    
    if (isset($_GET['action']) && $_GET['action'] === 'submit' && isset($_POST['region'])){
        file_put_contents(__DIR__.'/tx.txt',json_encode($_REQUEST));
        http_response_code(200);
        $bool = $controller->setOrder($planwhere, $_REQUEST);
        if ($_GET['orderResult'] == true && $bool) {

            file_put_contents(__DIR__.'/tx.txt',json_encode($_REQUEST));
            http_response_code(200);
        }
    }


    return \order_vm\Response\Response::viewClientOut('clientOrder', $region, $opratingsystem, $space, $plan, $_GET);
}


