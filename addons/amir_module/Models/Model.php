<?php

namespace amir_module\Models;

use    Illuminate\Database\Capsule\Manager as Capsule;
use Punic\Exception;

class Model extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'modulesmsnotify';


    public  function getMethodPayment()
    {

        return collect(localAPI('GetPaymentMethods'));
    }


    public function getAll()
    {
        return Capsule::table('modulesmsnotify')->all();
    }
     public function create($data)
        {
            return Capsule::table('modulesmsnotify')->insert($data);
        }

    public function whereAll($key, $where, $currency = null)
    {
        return (Capsule::table('tblpricing')
            ->join('tblproducts', 'tblpricing.relid', 'tblproducts.id')
            ->join('tblproductgroups', 'tblproductgroups.id', 'tblproducts.gid')
            ->join('tblcurrencies', 'tblcurrencies.id', 'tblpricing.currency')
            ->select(
                'tblcurrencies.code as name_tblcurrencies',
                'tblproductgroups.name as name_tblproductgroups',
                'tblproductgroups.id as id_tblproductgroups',
                'tblpricing.*',
                'tblproducts.*',
                'tblproducts.type as type_tblproducts',
                'tblpricing.type as type_tblpricing',
                'tblproducts.id as id_tblproducts',
                'tblpricing.id as id_tblpricing',
                'tblpricing.id as id_tblpricing')
            ->get())->where($key, $where)->where('currency', $currency)->where('type_tblpricing', 'product');
    }

    public function whereAllNotCurrency($key, $where)
    {
        return (Capsule::table('tblpricing')
            ->join('tblproducts', 'tblpricing.relid', 'tblproducts.id')
            ->join('tblproductgroups', 'tblproductgroups.id', 'tblproducts.gid')
            ->join('tblcurrencies', 'tblcurrencies.id', 'tblpricing.currency')
            ->select(
                'tblcurrencies.code as name_tblcurrencies',
                'tblproductgroups.name as name_tblproductgroups',
                'tblproductgroups.id as id_tblproductgroups',
                'tblpricing.*',
                'tblproducts.*',
                'tblproducts.type as type_tblproducts',
                'tblpricing.type as type_tblpricing',
                'tblproducts.id as id_tblproducts',
                'tblpricing.id as id_tblpricing'
                )
            ->get())->where($key, $where)->first();
    }

    public function getGroup()
    {
        return Capsule::table('tblproductgroups')
            ->select('tblproductgroups.*')
            ->get();
    }

    public function getCurrency()
    {
        return Capsule::table('tblcurrencies')
            ->select('tblcurrencies.*')
            ->get();
    }

    public function updateAllCycleGroup($idTblPricing, $data)
    {
        try {
            list($value, $out) = $this->checkZero($data, $idTblPricing);
            if ($out['id'] == null) {
                return false;
            }
            foreach ($out as $value) {
                Capsule::table('tblpricing')
                    ->where('id', $out['id'])
                    ->where('type', 'product')
                    ->update($out);
                echo "ID:" . $out['id'] . '||' . $value . "<br>";
            }
        } catch (Exception $e) {
            file_put_contents(__DIR__ . '/txt.txt', json_encode($e));
        }
    }

    public function updateCycleGroup($idTblPricing, $data)
    {
        try {
            list($value, $out) = $this->checkZero($data, $idTblPricing);
            if ($out['id'] == null) {
                return false;
            }
            Capsule::table('tblpricing')
                ->where('id', $out['id'])
                ->where('type', 'product')
                ->update($out);
            echo "<br>" . "ID:" . $out['id'];
            print_r(json_encode($out));
        } catch (\Exception $e) {
            file_put_contents(__DIR__ . '/txt.txt', json_encode($e));
        }
    }

    /**
     * @param $data
     * @param $idTblPricing
     * @return array
     */
    public function checkZero($data, $idTblPricing)
    {
        foreach ($data as $key => $value) {
            if ($value > 0) {
                $out['id'] = $idTblPricing;
                $out[$key] = $value;
            } else {
                unset($data[$key]);
            }
        }
        return array($value, $out);
    }


}