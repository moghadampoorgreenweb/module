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