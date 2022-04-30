<?php namespace tiket_module\Controllers;
include_once __DIR__ . '/../Models/Model.php';
include_once __DIR__ . '/../Models/Admin.php';
include_once __DIR__ . '/../Helpers/HelperModule.php';
include_once __DIR__ . '/../Configuration/Configuration.php';


use tiket_module\Configuration\Configuration;
use tiket_module\Models\Admin;
use tiket_module\Models\Model;

class ModuleController
{

    private $data;
    private $ticket;
    private $alladmin;
    private Model $model;
    private Admin $modelAdmin;

    public function __construct($data)
    {
        $this->data = $data;
        $this->model = new Model();
        $this->modelAdmin = new Admin();
        $this->setTicket(\tiket_module\Response\Response::getTickets());
        $this->setAlladmin(\tiket_module\Response\Response::getAdmin());
        $this->render();
    }

    public function render()
    {
        $this->assignTicket();
        //  $this->assignTicketVoteInsert();
        $this->getTicketInProgress();
        $this->getAdminTiketsOnline();
        //  d($this->modelAdmin->getAll());

    }


    public function getAdminTiketsOnline()
    {
        $tiket = $this->getTickets();
        $admin = $this->getAlladmin();
        $adminTiket = $this->getAdminTiketproccessOnline($admin, $tiket);

        return $adminTiket->toArray();
    }

    public function getAdminTiketsAll()
    {
        $tiket = $this->getTickets();
        $admin = $this->getAlladmin();
        $adminTiket = $this->getAdminTiketproccessAll($admin, $tiket);

        return $adminTiket->toArray();
    }


    public function getView()
    {
        $return = $this->getTableHaed();
        $getDepartman = \tiket_module\Response\Response::getDepartments();
        collect($this->getAdminTiketsAll())->map(function ($item) use (&$return, $getDepartman) {
            $online = collect($this->getAdminTiketsOnline())->where('id', '=', $item['id']);
            $bool = $online->isNotEmpty() ? 'online' : 'offline';
            $return .= "<tr><th scope='row'>{$item['id']}</th><td>{$item['fullName']}</td><td>{$item['count']}</td><td>{$bool}</td><td> ";
            collect($item['supportDepartmentIds'])->each(function ($items) use ($item, &$return, $getDepartman) {
                $out = collect($getDepartman['departments']['department'])->where('id', '=', $items['supportDepartmentIds'])->values();
                $return .= "{$out[0]['name']} ,";
            });
            $return .= "</td></tr>";
        });
        $return = $this->getTableFooter($return);
        return $return;
    }

    public function getTicketInProgress()
    {
        $dataadmin = $this->getTickets();

        $data = collect($dataadmin)->filter(function ($item) {
            return ($item['status'] == Configuration::STATUS_INPROGRESS ||
                    $item['status'] == Configuration::STATUS_OPEN) &&
                $item['flag'] == Configuration::FLAG_NULL &&
                $item['deptid'] == Configuration::DEPARTMANID;
        });
        return $data->values()->toArray();
    }


    public function assignTicket()
    {
        $dataadmin = $this->getAdminTiketsOnline();
        $datatiketOpen = $this->getTicketInProgress();
        if (collect($datatiketOpen)->isEmpty()) {
            return false;
        }
        $dataadmin = collect($dataadmin)->sortBy('count')->first();
        $datatiketOpen = collect($datatiketOpen)->first();
        list($dataadmin,$datatiketOpen)=$this->assignTicketVoteInsert($datatiketOpen, $dataadmin);

        $this->model->updates($datatiketOpen['id'],$dataadmin['id']);
        \tiket_module\Response\Response::updateTicket($datatiketOpen['id'], $dataadmin['id']);
    }

    public function assignTicketVoteInsert($dataTiketOpen, $dataadmin)
    {
        $this->model->create([
            'ticket_id' => $dataTiketOpen['id'],
            'vote' => rand(1, 10),
            'created_at' => date("Y-m-d H:i:s")
        ]);
        $adminvoteData = $this->modelAdmin->getAll();
        $ticketvoteData = $this->model->getAll();
        $ticketvoteData = collect($ticketvoteData)->where('ticket_id', '=', $dataTiketOpen['id']);
        $dataTiketOpen = collect($dataTiketOpen)->merge(['vote' => $ticketvoteData->values()[0]->vote]);
        $adminvoteData = $adminvoteData->where('admin_id', '=', $dataadmin['id'])->first();
        $adminvoteData = collect($dataadmin)->merge(['weight' => $adminvoteData->weight]);

        return [$adminvoteData,$dataTiketOpen];
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
            return $item == Configuration::DEPARTMANID;
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


    public function bindData(\Illuminate\Support\Collection $tiketid, $admin, $tiketvalue)
    {

        $data = $tiketid->map(function ($tiket) use ($admin, $tiketvalue) {

            $outData = collect($admin)->merge(['tickets' => $tiket])->merge(['count' => $tiketvalue]);

            return $tiket;
        });

        return $data;
    }

    /**
     * @param $admin
     * @param $tiket
     * @return \Illuminate\Support\Collection
     */

    public function getAdminTiketproccessOnline($admin, $tiket): \Illuminate\Support\Collection
    {
        $getAdmin = $this->getAdmin($admin);
        $staffOnline = \tiket_module\Response\Response::getStaffOnline();
        $getAdmin = collect($staffOnline['staffonline']['staff'])->map(function ($item) use ($admin) {
            return $this->getAdmin($admin)->where('username', '=', $item['adminusername'])->values()[0];
        })->values();
        if ($getAdmin->isEmpty()) {

            return false;
        }
        $adminTiket = collect($getAdmin)->map(function ($admin) use ($tiket) {
            $tiketid = collect($tiket)->where('flag', '=', $admin['id'])->where('deptid', '=', Configuration::DEPARTMANID)->values();
            $tiketvalue = collect($tiket)->where('flag', '=', $admin['id'])->where('deptid', '=', Configuration::DEPARTMANID)->values()->count();
            $data = $this->bindData($tiketid, $admin, $tiketvalue);

            return collect($admin)->merge(['ticket' => $data->toArray()])->merge(['count' => $tiketvalue]);
        });
        return $adminTiket;
    }

    /**
     * @param $admin
     * @param $tiket
     * @return \Illuminate\Support\Collection
     */
    public function getAdminTiketproccessAll($admin, $tiket): \Illuminate\Support\Collection
    {
        $getAdmin = $this->getAdmin($admin);
        $adminTiket = collect($getAdmin)->map(function ($admin) use ($tiket) {
            $tiketid = collect($tiket)->where('flag', '=', $admin['id'])->where('deptid', '=', Configuration::DEPARTMANID)->values();
            $tiketvalue = collect($tiket)->where('flag', '=', $admin['id'])->where('deptid', '=', Configuration::DEPARTMANID)->values()->count();
            $data = $this->bindData($tiketid, $admin, $tiketvalue);

            return collect($admin)->merge(['ticket' => $data->toArray()])->merge(['count' => $tiketvalue]);
        });
        return $adminTiket;
    }


    public function getAdminTiketproccessWhere($admin, $tiket, $departman): \Illuminate\Support\Collection
    {
        $adminTiket = collect($this->getAdmin($admin))->map(function ($admin) use ($tiket, $departman) {
            $tiketid = collect($tiket)->where('flag', '=', $admin['id'])->where('deptid', '=', $departman)->values();
            $tiketvalue = collect($tiket)->where('flag', '=', $admin['id'])->where('deptid', '=', $departman)->values()->count();
            $data = $this->bindData($tiketid, $admin, $tiketvalue);

            return collect($admin)->merge(['ticket' => $data->toArray()])->merge(['count' => $tiketvalue]);
        });
        return $adminTiket;
    }


    /**
     * @return mixed
     */
    public function getTickets()
    {
        return $this->ticket;
    }

    /**
     * @param mixed $ticket
     */
    public function setTicket($ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * @return mixed
     */
    public function getAlladmin()
    {
        return $this->alladmin;
    }

    /**
     * @param mixed $alladmin
     */
    public function setAlladmin($alladmin): void
    {
        $this->alladmin = $alladmin;
    }

    /**
     * @return string
     */
    public function getTableHaed(): string
    {
        $return = ' <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">id</th>
                          <th scope="col">Full name</th>
                          <th scope="col">count tiket</th>
                          <th scope="col">status</th>                      
                          <th scope="col">departman</th>                      
                        </tr>
                      </thead>
                      <tbody>';
        return $return;
    }

    /**
     * @param string $return
     * @return string
     */
    public function getTableFooter(string $return): string
    {
        $return .= ' </tbody>
                    </table>';
        return $return;
    }


}