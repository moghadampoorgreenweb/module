<?php
include_once __DIR__ . "/vendor/autoload.php";
include_once __DIR__ . "/Response/Response.php";
include_once __DIR__ . "/Report/Report.php";
include_once __DIR__ . "/Paginate/Render.php";
include_once __DIR__ . "/RenderExport/RenderExport.php";
include_once __DIR__ . "/Uploads/Import.php";
include_once __DIR__ . "/Error/ErrorReport.php";

use Rap2hpoutre\FastExcel\FastExcel;
use Dompdf\Dompdf;

if (!defined("WHMCS"))
    die("This file cannot be accessed directly");


use Illuminate\Database\Capsule\Manager as Capsule;


function suport_module_config()
{
    $configarray = array(
        "name" => "suport_module",
        "description" => "This is a sample config function for an addon module",
        "version" => "1.0",
        "author" => "WHMCS",
    );
    return $configarray;
}


function suport_module_activate()
{
    // Create custom tables and schema required by your module
    try {
        $table = Capsule::table('module_support_tiket');
        if ($table) {
            Capsule::schema()
                ->create(
                    'module_support_tiket',
                    function ($table) {
                        /** @var \Illuminate\Database\Schema\Blueprint $table */
                        $table->increments('id');
                        $table->integer('tiket_id');
                        $table->string('status_user');
                        $table->timestamps();
                    }
                );
        }
        Capsule::table('module_support_tiket')->insert([
            ['tiket_id' => 0,
                'status_user' => 'Upset_user',
                'created_at' => date("Y-m-d H:i:s"),],
            ['tiket_id' => 0,
                'status_user' => 'Normal_user',
                'created_at' => date("Y-m-d H:i:s"),],
            ['tiket_id' => 0,
                'status_user' => 'Technical_user',
                'created_at' => date("Y-m-d H:i:s"),],
            ['tiket_id' => 0,
                'status_user' => 'User_half',
                'created_at' => date("Y-m-d H:i:s"),],
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


function suport_module_deactivate()
{
    // Undo any database and schema modifications made by your module here
    try {
        Capsule::schema()
            ->dropIfExists('module_support_tiket');
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


function suport_module_output($vars)
{
    $report=new Report();
    $model = new Model();
    $module = $vars['modulelink'];
    $model->setOffset($_REQUEST['page'] * Model::PAGINATE);
    $previous = 0;
    $next = 1;
    $data = $model->allData();
    $out = Render::page($data);
    extract(Render::paginate($_GET['page'], $out));
    $allflags = $model->getFlag();
    if (isset($_REQUEST['status']) && !empty($_REQUEST['status'])) {
        $status = true;
        $allflags = $model->statusWhere($_REQUEST['status']);
        $out = Render::page($allflags);
        $allflags = $model->statusoffset($_REQUEST['status']);
        $data = $model->allDatawhere($_REQUEST['status']);
        extract(Render::paginate($_GET['page'], $out));
    }
    checkcurentPage();
    RenderExport::renderPdf($data,$_GET['pdfExport']);
    include_once __DIR__ . "/view/home.php";
    RenderExport::renderExel($data, $_GET['exportExel']);
    importExel($report);
}


function importExel(Report $report)
{
    if (!empty($_POST['importExel']) && !empty($_FILES["import"]["name"])) {
        Import::importExel($_FILES["import"]["name"], $_FILES['import']['tmp_name']);
        $data = Report::importExel($_FILES["import"]["name"], $_POST['importExel']);
        $report->createAll($data);
    }
}


function checkcurentPage()
{
    if (is_null($_GET['page']) && empty($_GET['page'])) {
        $_GET['page'] = 0;
    }
}


function suport_module_clientarea($vars)
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

