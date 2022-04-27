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


    public function setOrder(\Illuminate\Support\Collection $plan, $data)
    {
        $bool = $plan->isNotEmpty();
        if ($bool) {
            \order_vm\Helpers\HelperModule::addPlanOrder($this->data['plan'], $data);
        }
        return $bool;
    }


    /**
     * @param \Illuminate\Support\Collection $opratingsystem
     * @param \Illuminate\Support\Collection $space
     * @param \Illuminate\Support\Collection $plan
     * @param \order_vm\Controllers\ModuleController $controller
     * @param \Illuminate\Support\Collection $planwhere
     * @return void
     */
    public function ajaxHandel(\Illuminate\Support\Collection $opratingsystem, \Illuminate\Support\Collection $space, \Illuminate\Support\Collection $plan, \order_vm\Controllers\ModuleController $controller, \Illuminate\Support\Collection $planwhere)
    {
        $this->region($opratingsystem);
        $this->os($space);
        $this->disk($space);
        $this->plan($plan);
        $this->submit($controller, $planwhere);
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
     * @param \Illuminate\Support\Collection $opratingsystem
     * @return void
     */
    public function region(\Illuminate\Support\Collection $opratingsystem): void
    {
        $request = $this->getData();
        if (isset($request['action']) && $request['action'] === 'region' && isset($request['region'])) {
            $id = $request['region'];
            $os = $opratingsystem->filter(function ($item) use ($id) {
                return $item['region']['id'] == $id;
            })->values()->toArray();
            http_response_code(200);
            echo json_encode($os);
            die;
        }
    }

    /**
     * @param \Illuminate\Support\Collection $space
     * @return void
     */
    public function os(\Illuminate\Support\Collection $space): void
    {
        $request = $this->getData();
        if (isset($request['action']) && $request['action'] === 'os' && isset($request['region'])) {
            $id = $request['region'];
            $os = $space->filter(function ($item) use ($id) {
                return $item['opratingSystem']['id'] == $id;
            })->values()->toArray();
            http_response_code(200);
            echo json_encode($os);
            die;
        }
    }

    /**
     * @param \Illuminate\Support\Collection $space
     * @return void
     */
    public function disk(\Illuminate\Support\Collection $space): void
    {
        $request = $this->getData();
        if (isset($request['action']) && $request['action'] === 'disk' && isset($request['region'])) {
            $id = $request['region'];
            $os = $space->filter(function ($item) use ($id) {
                return $item['opratingSystem']['id'] == $id;
            })->values()->toArray();
            http_response_code(200);
            echo json_encode($os);
            die;
        }
    }

    /**
     * @param \Illuminate\Support\Collection $plan
     * @return void
     */
    public function plan(\Illuminate\Support\Collection $plan): void
    {
        $request = $this->getData();
        if (isset($request['action']) && $request['action'] === 'plan' && isset($request['region'])) {
            $id = $request['region'];
            $os = $plan->filter(function ($item) use ($id) {
                return $item['spase']['id'] == $id;
            })->values()->toArray();
            http_response_code(200);
            echo json_encode($os);
            die;
        }
    }

    /**
     * @param ModuleController $controller
     * @param \Illuminate\Support\Collection $planwhere
     * @return void
     */
    public function submit(ModuleController $controller, \Illuminate\Support\Collection $planwhere): void
    {
        $request = $this->getData();
        if (isset($request['action']) && $request['action'] === 'submit' && isset($request['region'])) {
            http_response_code(200);
            $bool = $controller->setOrder($planwhere, $request);
            if ($_GET['orderResult'] == true && $bool) {
                file_put_contents(__DIR__ . '/tx.txt', json_encode($request));
                http_response_code(200);
            }
        }
    }


}