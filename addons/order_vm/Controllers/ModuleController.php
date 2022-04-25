<?php
namespace order_vm\Controllers;
use order_vm\Models\Model;

include_once __DIR__ . '/../Models/Model.php';
include_once __DIR__ . '/../Helpers/HelperModule.php';


class ModuleController
{

    private $data;
    private Model $model;

    public function __construct($data)
    {
        $this->data = $data;
        $this->model = new \order_vm\Models\Model();
        $this->render();
    }

    public function render()
    {
        $this->order();
    }


    public function order()
    {

    }


   public function setOrder(\Illuminate\Support\Collection $plan)
    {
        $bool = $plan->isNotEmpty();
        if ($bool) {
            \order_vm\Helpers\HelperModule::addPlanOrder($this->data['plan']);
        }
        return $bool;
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




}