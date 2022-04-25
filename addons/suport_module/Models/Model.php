<?php

use    Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\DB;

include __DIR__ . '/../Responses/Response.php';

class Model extends \Illuminate\Database\Eloquent\Model
{

    const PAGINATE = 3;


    protected $table = 'module_support_tiket';
    private $offset;


    public function getOffset()
    {
        return $this->offset;
    }


    public function setOffset($offset)
    {
        $this->offset = $offset;
    }

    public function createOrUpdate($ticketid, $request)
    {

        try {
            if (empty($request) && is_null($request) | $request == 0) {

                return false;
            }

            $data = localAPI('GetTickets');
            if (collect($data['tickets']['ticket'])->where('ticketid',$ticketid)->isEmpty()){

                return  false;
            }

            echo "Inserted ticket id :". $ticketid ."<br>";
            $this->createOrupdated($ticketid, $request);
        } catch (Exception $e) {
            file_put_contents(__DIR__ . "/text.txt", json_encode($e));
        }
    }

    public function allData()
    {
        return Capsule::table("module_support_tiket")
            ->join('tbltickets', 'module_support_tiket.tiket_id', '=', 'tbltickets.id')
            ->join('tblclients', 'tbltickets.userid', '=', 'tblclients.id')
            ->join('tblticketdepartments', 'tblticketdepartments.id', '=', 'tbltickets.did')
            ->select('tbltickets.admin', 'module_support_tiket.id', 'module_support_tiket.tiket_id', 'module_support_tiket.status_user', 'tbltickets.title', 'tblclients.firstname', 'tblclients.lastname', 'tblclients.email', 'tblticketdepartments.name as dpname', 'tbltickets.date', 'tbltickets.date', 'tbltickets.updated_at')
            ->get();
    }

    public function allDatawhere($status)
    {
        return Capsule::table("module_support_tiket")
            ->join('tbltickets', 'module_support_tiket.tiket_id', '=', 'tbltickets.id')
            ->join('tblclients', 'tbltickets.userid', '=', 'tblclients.id')
            ->join('tblticketdepartments', 'tblticketdepartments.id', '=', 'tbltickets.did')
            ->select('tbltickets.admin', 'module_support_tiket.id', 'module_support_tiket.tiket_id', 'module_support_tiket.status_user', 'tbltickets.title', 'tblclients.firstname', 'tblclients.lastname', 'tblclients.email', 'tblticketdepartments.name as dpname', 'tbltickets.date', 'tbltickets.date', 'tbltickets.updated_at')
            ->where('status_user', $status)
            ->get();
    }

    public function statusWhere($status)
    {
        return Capsule::table("module_support_tiket")
            ->join('tbltickets', 'module_support_tiket.tiket_id', '=', 'tbltickets.id')
            ->join('tblclients', 'tbltickets.userid', '=', 'tblclients.id')
            ->join('tblticketdepartments', 'tblticketdepartments.id', '=', 'tbltickets.did')
            ->select('module_support_tiket.*', 'tbltickets.*', 'tblclients.*', 'tblticketdepartments.name as dpname')
            ->where('status_user', $status)
            ->limit(self::PAGINATE)
            ->get();
    }

    public function statusoffset($status)
    {
        return Capsule::table("module_support_tiket")
            ->join('tbltickets', 'module_support_tiket.tiket_id', '=', 'tbltickets.id')
            ->join('tblclients', 'tbltickets.userid', '=', 'tblclients.id')
            ->join('tblticketdepartments', 'tblticketdepartments.id', '=', 'tbltickets.did')
            ->select('module_support_tiket.*', 'tbltickets.*', 'tblclients.*', 'tblticketdepartments.name as dpname')
            ->where('status_user', $status)
            ->limit(self::PAGINATE)
            ->offset($this->getOffset())
            ->get();
    }

    public function tiketWhere($status)
    {
        return Capsule::table("module_support_tiket")
            ->join('tbltickets', 'module_support_tiket.tiket_id', '=', 'tbltickets.id')
            ->join('tblclients', 'tbltickets.userid', '=', 'tblclients.id')
            ->join('tblticketdepartments', 'tblticketdepartments.id', '=', 'tbltickets.did')
            ->select('module_support_tiket.*', 'tbltickets.*', 'tblclients.*', 'tblticketdepartments.name as dpname')
            ->where('tiket_id', $status)
            ->first();
    }

    public function getFlag($status = null)
    {
        include __DIR__ . "/../vendor/autoload.php";
        if (!Capsule::table("module_support_tiket")->where('status_user', $status)) {
            return false;
        }
        if ($status != null) {
            return $this->whereStatus($status);
        }
        return Capsule::table("module_support_tiket")
            ->join('tbltickets', 'module_support_tiket.tiket_id', '=', 'tbltickets.id')
            ->join('tblclients', 'tbltickets.userid', '=', 'tblclients.id')
            ->join('tblticketdepartments', 'tblticketdepartments.id', '=', 'tbltickets.did')
            ->select('module_support_tiket.*', 'tbltickets.*', 'tblclients.*', 'tblticketdepartments.name as dpname')
            ->limit(self::PAGINATE)
            ->offset($this->getOffset())
            ->get();
    }


    private function whereStatus(string $status)
    {
        return Capsule::table("module_support_tiket")
            ->join('tbltickets', 'module_support_tiket.tiket_id', '=', 'tbltickets.id')
            ->join('tblclients', 'tbltickets.userid', '=', 'tblclients.id')
            ->join('tblticketdepartments', 'tblticketdepartments.id', '=', 'tbltickets.did')
            ->select('module_support_tiket.*', 'tbltickets.*', 'tblclients.*', 'tblticketdepartments.name as dpname')
            ->where('status_user', $status)
            ->limit(self::PAGINATE)
            ->offset($this->getOffset())
            ->get();
    }


    private function createOrupdated($ticketid, $request)
    {
        if (!Capsule::table('module_support_tiket')->where('tiket_id', $ticketid)->first()) {
            Capsule::table('module_support_tiket')
                ->Insert([
                    'tiket_id' => $ticketid,
                    'status_user' => $request,
                    'created_at' => date("Y-m-d H:i:s"),
                ]);
            \fellingCustomer\Response\Response::successResponse();
        } else {
            Capsule::table('module_support_tiket')->where('tiket_id', $ticketid)
                ->update([
                    'tiket_id' => $ticketid,
                    'status_user' => $request,
                    'updated_at' => date("Y-m-d H:i:s"),
                ]);
            \fellingCustomer\Response\Response::updateResponse();
        }
    }


}