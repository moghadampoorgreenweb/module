<?php namespace tiket_module\Controllers;
include_once __DIR__ . '/../Models/Model.php';
include_once __DIR__ . '/../Helpers/HelperModule.php';


use order_vm\Response\Response;
use tiket_module\Models\Model;
use   tiket_module\Helpers\HelperModule;

class ModuleController
{

    private $data;
    private Model $model;

    public function __construct($data)
    {
        $this->data = $data;
        $this->model = new Model();
        $this->render();
    }

    public function render()
    {
        $this->single();
    }


    public function single()
    {
        $request = $this->getData();
        $tiket = \tiket_module\Response\Response::getTickets();
        echo "<pre>";
        collect($tiket)->each(function ($item) {

            //  print_r($item);
        });
        echo "</pre>";

        $admin = \tiket_module\Response\Response::getAdmin();
        echo "<pre>";
        //  dd($tiket);
        $adminTiket = collect($this->getAdmin($admin))->map(function ($admin) use ($tiket) {
             $tiketid= collect($tiket)->where('flag', '=', $admin['id'])->values();
           return  $tiketid->map(function ($item) use ($admin){
                return  collect($item)->add($admin);
             });

        });

        dd($adminTiket);

        echo "</pre>";

    }


    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }

    /**
     * @param $supportDepartmentIds
     * @return \Illuminate\Support\Collection
     */
    public function checkDepartman($supportDepartmentIds): \Illuminate\Support\Collection
    {
        $out = collect($supportDepartmentIds)->filter(function ($item) {
            return $item == 2;
        });
        return $out;
    }


    public function getAdmin($admin)
    {
        return collect($admin)->map(function ($item) {
            $out = $this->checkDepartman($item['supportDepartmentIds']);
            if ($out->isNotEmpty()) {
                return $item;
            }
        })->filter(function ($item) {
            return $item != null;
        })->values();
    }


}