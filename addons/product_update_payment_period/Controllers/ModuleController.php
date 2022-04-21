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
        $this->update();
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

    public function update()
    {
        $request = $this->getData();
        if (!is_null($request['product']) && !empty($request['product'])) {
            $data = $this->model->whereAllNotCurrency('id_tblpricing', $request['product']);
            $data->each(function ($item) use ($request, $data) {
                //var_dump($item);
                $this->model->updateCycleGroup($request['product'], [
                    $request['cycle'] =>$this->operation($request['amount'],
                        $item->$request['cycle'],
                        $request['operation'])
                ]);
            });
            echo "<pre>";
var_dump($request);
          //  $this->bulkUpdate($data,$request,$item->$request['cycle']);
            file_put_contents(__DIR__ . '/txt.txt', json_encode($data->toArray()));
            //    $this->model->updateCycleGroup($request['product'],$data);
        }
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
                    $month => $this->operation($request['amount'],
                    $item->$month,
                    $request['operation']),
            ]);
        });
    }

    public function updated($request, $month)
    {
        $data = $this->model->whereAll('id_tblproductgroups', $request['group'], $request['currency']);
        $this->bulkUpdate($data, $request, $month);
    }


}