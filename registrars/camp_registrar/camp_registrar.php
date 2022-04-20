<?php

include __DIR__ . "/vendor/autoload.php";
include __DIR__ . "/Api.php";
include __DIR__ . "/MultiRigistrar.php";

function camp_registrar_getConfigArray()
{

    return [
        "base_url" => [
            "FriendlyName" => "base url",
            "Type" => "text", # Text Box
            "Description" => "Textbox",
        ],
        "api_token" => [
            "FriendlyName" => "api token",
            "Type" => "textarea", # Textarea
        ],
    ];

}

function camp_registrar_RegisterDomain($vars)
{
    $api = new Api($vars['base_url'], $vars['api_token']);
    $multiRegister = new MultiRigistrar($api);
    $contact = [
        'name' => $vars['adminfirstname'] . ' ' . $vars['adminlastname'],
        'email' => $vars['adminemail'],
    ];
    $dnsList = [
        $vars['ns1'],
        $vars['ns2'],
    ];
    $out = $multiRegister->register($vars['domain_punycode'], $contact, $dnsList, $vars['regperiod']);
    file_put_contents(__DIR__ . '/f.json', json_encode($out));

}


function camp_registrar_TransferDomain($vars)
{
    $contact = [
        'name' => $vars['adminfirstname'] . ' ' . $vars['adminlastname'],
        'email' => $vars['adminemail'],
    ];
    $dnsList = [
        $vars['ns1'],
        $vars['ns2'],
    ];
    $api = new Api($vars['base_url'], $vars['api_token']);
    $multiRegister = new MultiRigistrar($api);

    $out = $multiRegister->transfer($vars['domain_punycode'], $vars['original']['eppcode'], $contact, $dnsList, $vars['regperiod']);
    file_put_contents(__DIR__ . '/f.json', json_encode($out));
}

function camp_registrar_RenewDomain($vars)
{
    $api = new Api($vars['base_url'], $vars['api_token']);
    $multiRegister = new MultiRigistrar($api);
    $out = $multiRegister->renew($vars['domain_punycode'], $vars['regperiod']);
    file_put_contents(__DIR__ . '/f.json', json_encode($out));
}


function camp_registrar_GetEPPCode($vars)
{
    $api = new Api($vars['base_url'], $vars['api_token']);
    $multiRegister = new MultiRigistrar($api);
    $epp = getEpp($multiRegister, $vars['domain_punycode']);
    var_dump($epp);
    return $epp;
}


function camp_registrar_GetDomainInformation($vars)
{
//var_dump(json_encode($vars));die;
}

function camp_registrar_GetNameservers($vars)
{

}


function camp_registrar_SaveNameservers($vars)
{
    $dns = [
        $vars['ns1'],
        $vars['ns2'],
        $vars['ns3'],
        $vars['ns4'],
        $vars['ns5'],
    ];
    // var_dump(json_encode($vars));die;
    $api = new Api($vars['base_url'], $vars['api_token']);
    $multiRegister = new MultiRigistrar($api);
    $out = $multiRegister->changeDns($vars['domain_punycode'], $dns);
    file_put_contents(__DIR__ . '/f.json', json_encode($out));
//    var_dump(json_encode($vars));die;
}


function camp_registrar_GetRegistrarLock($vars)
{
    var_dump($vars);
    die;
}

function camp_registrar_SaveRegistrarLock($vars)
{
    $api = new Api($vars['base_url'], $vars['api_token']);
    $multiRegister = new MultiRigistrar($api);
    $out = $multiRegister->lock($vars['domain_punycode'], $vars['lockenabled']);
    file_put_contents(__DIR__ . '/f.json', json_encode($out));
}


function camp_registrar_GetContactDetails($vars)
{
    $api = new Api($vars['base_url'], $vars['api_token']);
    $multiRegister = new MultiRigistrar($api);
    $out = $multiRegister->whois($vars['domain_punycode']);
    $contact = json_decode($out);
    $fieldContact = collect($contact->contacts->holder)->map(function ($item, $key) {
        return [$key] = $item;
    });
    return [
        'Holder' => $fieldContact->toArray(),
    ];
}

function camp_registrar_SaveContactDetails($vars)
{
    $api = new Api($vars['base_url'], $vars['api_token']);
    $multiRegister = new MultiRigistrar($api);
    $vars['contactdetails']['Holder']['state'] = $vars['adminfullstate'];
    $vars['contactdetails']['Holder']['address'] = $vars['adminaddress1'];
    $vars['contactdetails']['Holder']['fax'] = $vars['adminphonenumber'];
    $vars['contactdetails']['Holder']['organization'] = $vars['admincompanyname'];
    $out = $multiRegister->savecontactdetails($vars['domain_punycode'], $vars['contactdetails']['Holder']);
    file_put_contents(__DIR__ . '/f.json', json_encode($out));
}


function camp_registrar_RegisterNameserver($vars)
{
    $api = new Api($vars['base_url'], $vars['api_token']);
    $multiRegister = new MultiRigistrar($api);
    $out = $multiRegister->RegisterNameserver($vars['domain_punycode'], $vars);
    file_put_contents(__DIR__ . '/f.json', json_encode($out));
}


function camp_registrar_ModifyNameserver($vars)
{
    $api = new Api($vars['base_url'], $vars['api_token']);
    $multiRegister = new MultiRigistrar($api);
    $out = $multiRegister->ModifyNameserver($vars['domain_punycode'], $vars);
    file_put_contents(__DIR__ . '/f.json', json_encode($out));
}

function camp_registrar_DeleteNameserver($vars)
{
    $api = new Api($vars['base_url'], $vars['api_token']);
    $multiRegister = new MultiRigistrar($api);
    $out = $multiRegister->DeleteNameserver($vars['domain_punycode'], $vars);
    file_put_contents(__DIR__ . '/f.json', json_encode($out));
}

function camp_registrar_RequestDelete($vars)
{
    $api = new Api($vars['base_url'], $vars['api_token']);
    $multiRegister = new MultiRigistrar($api);
    $out = $multiRegister->DeleteNameserver($vars['domain_punycode'], $vars);
    file_put_contents(__DIR__ . '/f.json', json_encode($out));
}


function camp_registrar_ClientArea($vars)
{
    return "<h1> hello my frind. </h1>";
}

function camp_registrar_ClientAreaCustomButtonArray()
{
    return array(
        'Push Domain' => 'push',
        'Push Domain2' => 'push2',
        'Push Domain3' => 'push3',
    );
}

function camp_registrar_ClientAreaAllowedFunctions()
{
    return array(
        'Push Domain' => 'push',
        'Push Domain2' => 'push2',
        'Push Domain3' => 'push3',
    );
}

function camp_registrar_Sync()
{

}

function camp_registrar_TransferSync()
{

}

function camp_registrar_GetTldPricing()
{

}


/**
 * @param MultiRigistrar $multiRegister
 * @param $domain_punycode
 * @return mixed
 */
function getEpp(MultiRigistrar $multiRegister, $domain_punycode)
{
    $out = $multiRegister->epp($domain_punycode);
    $epp = (json_decode($out))->data[0]->data->epp;
    return $epp;
}



