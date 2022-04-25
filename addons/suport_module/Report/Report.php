<?php
include_once __DIR__ . "/../Responses/Response.php";
include_once __DIR__ . "/../Config/Configuration.php";
include_once __DIR__ . "/../Models/Model.php";
use Rap2hpoutre\FastExcel\FastExcel;
use \suport_module\Config\Configuration;

class Report
{
    private  $model;

    public function __construct()
    {
        $this->model = new Model();
    }

    public static function exportExel($data)
    {
        $baseUrl = Configuration::BASE_URL . Configuration::FILE_NAME;
        (new FastExcel(collect($data)))->export(__DIR__ . '/..' . Configuration::FILE_NAME);
        header("Location: $baseUrl");
    }

    public static function importExel($filename, $bool = false)
    {
        if (empty($bool) && $bool == false) {

            return false;
        }
        $path = Configuration::BASEFILE . basename($filename);
        if (!file_exists($path)) {

            return false;
        }

        try {

            return (new FastExcel())->import($path);
        } catch (Exception $e) {
            file_put_contents(__DIR__ . '/txt.txt', $e);
        }
    }

    public function createAll($data)
    {
        $data->each(function ($item) {

                $this->model->createOrUpdate($item['tiket_id'], $item['status_user']);
        });
    }
}