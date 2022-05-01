<?php


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
function verifyCode_module_config()
{
    $results = localAPI('GetEmailTemplates', ['type' => 'general']);
    file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . 'file.json', json_encode($results['emailtemplates']['emailtemplate']));

    $templates = collect($results['emailtemplates']['emailtemplate'])->map(function ($item) {
        return $item['name'];
    })->toArray();
    $item = implode(',', $templates);


    $configarray = array(
        "name" => "verifyCode_module",
        "description" => "<span style='margin-top: 5px;font-size: 10px;color: green;display: inline-block;border-top: 1px solid;border-bottom: 1px solid;line-height: 25px;padding: 0 10px;'>ماژولی برای ورود با رمز یکبار مصرف توسعه  یافته است .</span>",
        "version" => "1.0",
        "author" => "Majid Farzaneh (iran server)",

        'fields' => [
            'template Name' => [
                'FriendlyName' => 'template Name',
                'Type' => 'dropdown',
                "Options" => $item,
                'Description' => 'This variable {$token} is mandatory in the template.',
            ],
        ],

    );
    return $configarray;
}


function verifyCode_module_upgrade($vars)
{

    $currentlyInstalledVersion = $vars['version'];
    file_put_contents(__DIR__ . '/LogModule.txt', $currentlyInstalledVersion);

    if ($currentlyInstalledVersion < 1.3) {
        file_put_contents(__DIR__ . '/LogModule.txt', 'ok version');

        try {
            $table = Capsule::table('verifyCode');
            file_put_contents(__DIR__ . '/LogModule.txt', $table);
            if ($table) {
                file_put_contents(__DIR__ . '/LogModule.txt', 'created_table campain');
                $schema = Capsule::schema();
                $schema->create('verifyCode', function ($table) {
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
                'description' => 'Unable to create verifyCode_module: ' . $e->getMessage(),
            ];
        }
    }
}


function verifyCode_module_activate()
{

}


function verifyCode_module_output($var)
{

}

function verifyCode_module_clientarea($var)
{
    define('BASE_URL', '/modules/addons/verifyCode_module/');
    define('MODULE_URL', $var['modulelink']);
    $action = (isset($_GET['action'])) ? $_GET['action'] : 'main/index';
    list($controller, $method) = explode('/', $action);
    $controller = trim($controller);
    $controller = $controller . 'Controller';

    $method = trim($method);

    ($controller == "") ? $controller = "main" : $controller;
    ($method == '') ? $method = "index" : $method;


    require __DIR__ . "/lib/functions.php"; // library functions
    require __DIR__ . "/controller/mainController.php";
    require __DIR__ . "/controller/" . $controller . '.php';

    // require_once __DIR__."/Configuration/Configuration.php";

    $class = new $controller();
    return $class->$method();
}
