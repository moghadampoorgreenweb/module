<?php
//include __DIR__ . '/vendor/autoload.php';

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ValidatedInput;
use Respect\Validation\Validator as v;
use Savvot\Random\XorShiftRand;



/**
 * Created by PhpStorm.
 * User: m.farzaneh
 * Date: 4/28/2018
 * Time: 10:43 AM
 */
function is_customers_config()
{
    $configarray = array(
        "name" => "مشتریان",
        "description" => "<span style='margin-top: 5px;font-size: 10px;color: green;display: inline-block;border-top: 1px solid;border-bottom: 1px solid;line-height: 25px;padding: 0 10px;'>ماژولی برای تفکیک اطلاعات مشتریان بر اساس محصولات خریداری شده</span>",
        "version" => "1.0",
        "author" => "Majid Farzaneh (iran server)",
//        "fields" => array(
//            "option1" => array ("FriendlyName" => "عنوان ماژول", "Type" => "text", "Size" => "255",
//                "Default" => "مشتریان", ),
//        )
    );
    return $configarray;
}


function is_customers_upgrade($vars)
{

    $currentlyInstalledVersion = $vars['version'];
    file_put_contents(__DIR__ . '/LogModule.txt', $currentlyInstalledVersion);

    if ($currentlyInstalledVersion < 1.3) {
        file_put_contents(__DIR__ . '/LogModule.txt', 'ok version');

        try {
            $table = Capsule::table('campaign');
            file_put_contents(__DIR__ . '/LogModule.txt', $table);
            if ($table) {
                file_put_contents(__DIR__ . '/LogModule.txt', 'created_table campain');
                $schema = Capsule::schema();
                $schema->create('campaign', function ($table) {
                    /** @var Blueprint $table */
                    $table->id();
                    $table->string('email', 255);
                    $table->string('code');
                    $table->dateTime('verifed_at')->nullable();
                    $table->dateTime('expired_at');
                    $table->string('tries')->nullable();
                    $table->timestamps();
                });
            }
        } catch (Exception $e) {
            file_put_contents(__DIR__ . '/LogModule.txt', $e);
            return [
                'status' => "error",
                'description' => 'Unable to create is_customers: ' . $e->getMessage(),
            ];
        }
    }
}


function is_customers_activate()
{

}


function is_customers_output($var)
{
    define('BASE_URL', '/modules/addons/is_customers/');
    define('MODULE_URL', $var['modulelink']);
    $action = (isset($_GET['action'])) ? $_GET['action'] : 'main/index';
    list($controller, $method) = explode('/', $action);
    $controller = trim($controller);
    $method = trim($method);
    ($controller == "") ? $controller = "main" : $controller;
    ($method == '') ? $method = "index" : $method;
    require_once __DIR__ . "/lib/functions.php"; // library functions
    require_once __DIR__ . "/controller/mainController.php";
    require_once __DIR__ . "/controller/" . $controller . '.php';
    $class = new $controller();
    return $class->$method();
}

function is_customers_clientarea($var)
{
    define('BASE_URL', '/modules/addons/is_customers/');
    define('MODULE_URL', $var['modulelink']);
    $action = (isset($_GET['action'])) ? $_GET['action'] : 'main/index';
    list($controller, $method) = explode('/', $action);
    $controller = trim($controller);
    $method = trim($method);
    ($controller == "") ? $controller = "main" : $controller;
    ($method == '') ? $method = "index" : $method;
    require_once __DIR__ . "/lib/functions.php"; // library functions
    require_once __DIR__ . "/controller/mainController.php";
    require_once __DIR__ . "/controller/" . $controller . '.php';
    $class = new $controller();
    return $class->$method();

}
