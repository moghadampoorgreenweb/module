<?php
include_once __DIR__ . '/../Models/Model.php';
include_once __DIR__ . '/../Helpers/HelperModule.php';

use amir_module\Models\Model;
use   amir_module\Helpers\HelperModule;
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

        if (is_null($request['massege']) && empty($request['massege'])) {
            return false;
        }
        if (is_null($request['user']) && empty($request['user'])) {
            return false;
        }
      //  dd($request);

        $this->update();
    }



    public function update()
    {
        $request = $this->getData();
        $users=HelperModule::getClients();
        $data = collect($request['user'])->map(function ($userId) use ($request) {
            if (HelperModule::whereClients('id',$userId,'=')->isEmpty()){

                return false;
            }
            $data=HelperModule::whereClientDetails($userId);
            if (empty($data['phonenumber'])){
                d('Phone number null.');
                return false;
            }
            $this->model->create([
                'user_id' => $userId,
                'body' => $request['massege'],
                'phone' => $data['phonenumber'],
                'status' => 'pending',
                'created_at' =>date("Y-m-d H:i:s"),
            ]);
        });
    }























    public function group()
    {
        $request = $this->getData();
        if (is_null($request['amount']) & empty($request['amount']))
            if (is_null($request['cycle']) & empty($request['cycle']) | is_null($request['group']) & empty($request['group'])) {
                return false;
            }
        if (is_null($request['currency']) & empty($request['currency'])) {
            return false;
        }
        $this->updated($request['cycle']);
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
                $month => $this->operation($request['amount'],
                    $item->$month,
                    $request['operation']),
            ]);
        });
    }

    public function updated($month)
    {
        $request = $this->getData();
        $data = collect($request['currency'])->map(function ($currency) use ($request) {
            return collect($request['group'])->map(function ($group) use ($request, $currency) {
                return $this->model->whereAll('id_tblproductgroups', $group, $currency);
            });
        });
        collect($request['cycle'])->map(function ($cycle) use ($request, $data) {
            $data->map(function ($groups) use ($request, $cycle) {
                $groups->map(function ($group) use ($cycle, $request) {
                    $group->map(function ($item) use ($cycle, $request) {
                        $this->model->updateCycleGroup($item->id_tblpricing, [
                            $cycle => $this->operation($request['amount'],
                                $item->$cycle,
                                $request['operation'])
                        ]);
                    });
                });
            });
        });
    }


}