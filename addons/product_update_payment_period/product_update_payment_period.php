<?php

include_once __DIR__.'/vendor/autoload.php';
include_once __DIR__.'/Models/Model.php';
include_once __DIR__.'/Controllers/ModuleController.php';
include_once __DIR__.'/Helpers/HelperModule.php';


if (!defined("WHMCS"))
    die("This file cannot be accessed directly");


use Illuminate\Database\Capsule\Manager as Capsule;
use product_update_payment_period\Models\Model ;


function product_update_payment_period_config()
{
    $configarray = array(
        "name" => " product_update_payment_period",
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



function product_update_payment_period_activate()
{
    // Create custom tables and schema required by your module
    try {
        $table = Capsule::table('product_update_payment_period');
        if ($table) {
            Capsule::schema()
                ->create(
                    'product_update_payment_period',
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
        Capsule::table('product_update_payment_period')->insert([
            'user_id' => 1,
            'body' => 'amirrza',
            'phone' => '09354114548',
            'status' => 'pending',
            'created_at' =>date("Y-m-d H:i:s"),
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


function product_update_payment_period_deactivate()
{
    // Undo any database and schema modifications made by your module here
    try {
        Capsule::schema()
            ->dropIfExists('product_update_payment_period');
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


function product_update_payment_period_output($vars)
{
    $controller=new ModuleController($_REQUEST);
    $model=new Model();
    $data= $model->getAll();
    $group= $model->getGroup();
    $currency= $model->getCurrency();

    include __DIR__ . "/view/home.php";

}

/**
 * @param int $total
 * @param int $value
 * @return int
 */



function product_update_payment_period_clientarea($vars)
{
    return array(
        'pagetitle' => 'Addon Module',
        'breadcrumb' => array('index.php?m=demo' => 'Demo Addon'),
        'templatefile' => 'clienthome',
        'requirelogin' => true, # accepts true/false
        'forcessl' => false, # accepts true/false
        'vars' => array(
            'testvar' => 'demo',
            'anothervar' => 'value',
            'sample' => 'test',
        ),
    );

}

