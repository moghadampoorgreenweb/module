<?php
include_once __DIR__ . '/../Models/Model.php';
include_once __DIR__ . '/../Helpers/HelperModule.php';

use product_update_payment_period\Models\Model;

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
        $this->month();
    }


    public function month()
    {
        $request = $this->getData();
        if (is_null($request['amount']) & empty($request['amount']))
        if (is_null($request['cycle']) & empty($request['cycle']) | is_null($request['group']) & empty($request['group'])) {
            return false;
        }
        if (is_null($request['currency']) & empty($request['currency'])) {
            return false;
        }
        $this->updated($request, $request['cycle']);
    }


    public function operation($key, $value, $opration = null)
    {
        if (!is_null($opration) && !empty($opration) && $opration == 'Percent') {
            return HelperModule::getPercent($key, $value);
        }
        return HelperModule::getTotal($key, $value);
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
     * @param \Illuminate\Support\Collection $data
     * @param mixed $request
     * @param string $month
     * @return void
     */
    public function bulkUpdate(\Illuminate\Support\Collection $data, $request, $month)
    {
        $data->each(function ($item) use ($request, $month) {
            $this->model->updateAllCycleGroup($item->id_tblpricing, [
                $month => $this->operation($request['amount'], $item->$month, $request['operation']),
            ]);
        });
    }

    public function updated($request, $month)
    {
        $data = $this->model->whereAll('id_tblproductgroups', $request['group'], $request['currency']);
        $this->bulkUpdate($data, $request, $month);
    }


}