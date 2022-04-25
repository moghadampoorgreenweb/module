<?php

namespace order_vm\Response;

class Response
{
    public static function success()
    {
        return [
            'status' => 201,
        ];

    }

    public static function serverRegion()
    {
        return collect([
            ['id' => 1,
                'name' => 'iran'],
            ['id' => 2,
                'name' => 'germany'],
        ]);
    }

    public static function opratingSystem()
    {
        return collect([
            ['id' => 1,
                'name' => 'ubuntu'],
            ['id' => 2,
                'name' => 'windows server'],
            ['id' => 3,
                'name' => 'centos 8'],
        ]);
    }

    public static function space()
    {
        return collect([
            ['id' => 1,
                'name' => 'SSD'],
            ['id' => 2,
                'name' => 'HDD'],

        ]);
    }


    public static function serverPlan()
    {
        return collect([
            [
                'id' => 1,
                'price'=>1000,
                'name' => 'plan1',
                'region' => [
                    'id' => 1,
                    'name' => 'iran',
                ],
                'spase' => [
                    'id' => 1,
                    'name' => 'HDD'
                ],
                'opratingsystem' => [
                    'id' => 1,
                    'name' => 'ubuntu'
                ],
                'descripion' => 'cpu 1 Ram 1 10GB $5',
            ],
            [
                'id' => 2,
                'price'=>2000,
                'name' => 'plan2',
                'region' => [
                    'id' => 2,
                    'name' => 'iran',
                ],
                'spase' => [
                    'id' => 2,
                    'name' => 'HDD'
                ],
                'opratingsystem' => [
                    'id' => 2,
                    'name' => 'windows server'
                ],
                'descripion' => 'cpu 2 Ram 2 3GB $4',
            ],
            [
                'id' => 3,
                'price'=>3000,
                'name' => 'plan3',
                'region' => [
                    'id' => 2,
                    'name' => 'germany',
                ],
                'spase' => [
                    'id' => 2,
                    'name' => 'HDD'
                ],
                'opratingsystem' => [
                    'id' => 3,
                    'name' => 'centos 8'
                ],
                'descripion' => 'cpu 15 Ram 12 16GB $65',
            ],
            [
                'id' => 4,
                'price'=>4000,
                'name' => 'plan4',
                'region' => [
                    'id' => 2,
                    'name' => 'germany',
                ],
                'spase' => [
                    'id' => 2,
                    'name' => 'HDD'
                ],
                'opratingsystem' => [
                    'id' => 3,
                    'name' => 'centos 8'
                ],
                'descripion' => 'cpu 15 Ram 12 16GB $65',
            ],
            [
                'id' => 5,
                'price'=>2000,
                'name' => 'plan1',
                'region' => [
                    'id' => 1,
                    'name' => 'iran',
                ],
                'spase' => [
                    'id' => 1,
                    'name' => 'HDD'
                ],
                'opratingsystem' => [
                    'id' => 2,
                    'name' => 'windows server'
                ],
                'descripion' => 'cpu 1 Ram 1 10GB $5',
            ],
        ]);
    }

    public static function wherePlan($region, $spase,$opratingsystem)
    {
        $plan = self::serverPlan();
        return $plan->where('region.id', '=', $region)
            ->where('spase.id', '=', $spase)
            ->where('opratingsystem.id', '=', $opratingsystem);
            ;
    }
    public static function whereId($id)
    {
        $plan = self::serverPlan();
        return $plan->where('id', '=', $id)->first();

    }


    public static function viewClientOut($template,$region,$opratingsystem,$space,$plan,$get)
    {
        return array(
            'pagetitle' => 'Addon Module',
            'breadcrumb' => array('index.php?m=order_vm' => 'orderVm'),
            'templatefile' => $template,
            'requirelogin' => true, # accepts true/false
            'forcessl' => false, # accepts true/false
            'vars' => array(
                'region' => $region,
                'opratingsystem' => $opratingsystem,
                'space' => $space,
                'plan' => $plan,
                'get' => $get,
            ),
        );
    }



}