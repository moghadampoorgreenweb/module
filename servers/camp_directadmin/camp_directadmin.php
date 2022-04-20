<?php


require __DIR__ . '/vendor/autoload.php';

use UxWeb\SweetAlert\SweetAlert;

function camp_directadmin_ConfigOptions()
{
    $data = Illuminate\Database\Capsule\Manager::table('tblproducts')->where('id', $_POST['id'])->first();
    $params["serverhostname"] = $data->configoption1;
    $params["serverusername"] = $data->configoption3;
    $params["serverpassword"] = $data->configoption4;
    $params["serverhttpprefix"] = 'https';
    $params["serverport"] = $data->configoption2;
    $request = package($params);

    return [
        "ip" => [
            "FriendlyName" => "Ip",
            "Type" => "text",
            "Size" => "100",
            "Description" => "ip",
            "Default" => "192.168.2.22",
        ],
        "port" => [
            "FriendlyName" => "port",
            "Type" => "text",
            "Default" => "4042",
        ],

        "username" => [
            "FriendlyName" => "UserName",
            "Type" => "text",
        ],
        "password" => [
            "FriendlyName" => "Password",
            "Type" => "password",
        ],

        "packages" => [
            'Type' => 'dropdown',
            "Options" => $request->toArray()
        ],
    ];
}

/**
 * @param $params
 * @return \Illuminate\Support\Collection
 */
function package($params): \Illuminate\Support\Collection
{
    $result = camp_directadmin_directadmin_request('CMD_API_PACKAGES_USER', [], $params);

    $packages = collect($result['list'])->mapWithKeys(function ($item) {
        return [
            $item => $item
        ];
    });

    return $packages;
}

function camp_directadmin_CreateAccount($params)
{

    $command = "CMD_API_ACCOUNT_USER";
    $fields["action"] = "create";
    $fields["add"] = "Submit";
    $fields["username"] = $params["username"];
    $fields["email"] = $params["clientsdetails"]["email"];
    $fields["passwd"] = $params["password"];
    $fields["passwd2"] = $params["password"];
    $fields["domain"] = $params["domain"];
    $fields["ip"] = $params["configoption1"];
    $fields["notify"] = "no";
    $fields["package"] = $params["configoption5"];
    $params = getParams($params);
    $results = camp_directadmin_directadmin_request($command, $fields, $params);

    return $results['errors'] == 0 ? true : $results['message'];


}

function camp_directadmin_TerminateAccount(array $params)
{

    $command = "CMD_API_SELECT_USERS";
    $fields["delete"] = "yes";
    $fields["confirmed"] = "Confirm";
    $fields["select0"] = $params['username'];
    $params = getParams($params);
    $results = camp_directadmin_directadmin_request($command, $fields, $params, true);

    return $results['errors'] == 0 ? true : $results['message'];

}

function camp_directadmin_SuspendAccount(array $params)
{
    $command = "CMD_API_SELECT_USERS";
    $ip = $params["configoption1"];
    $fields["suspend"] = "Suspend/Unsuspend";
    $fields["select0"] = $params['username'];


    $params = getParams($params);

    $results = camp_directadmin_directadmin_request($command, $fields, $params, true);
    return $results['errors'] == 0 ? true : $results['message'];

}

function camp_directadmin_UnsuspendAccount(array $params)
{

    $command = "CMD_API_SELECT_USERS";

    $fields["suspend"] = "Suspend/Unsuspend";
    $fields["select0"] = $params['username'];


    $params = getParams($params);

    $results = camp_directadmin_directadmin_request($command, $fields, $params, true);
    return $results['errors'] == 0 ? true : $results['message'];


}

function camp_directadmin_ChangePackage(array $params)
{
    try {

        $command = 'CMD_API_MODIFY_USER';
        $fields = [
            'action' => 'package',
            'user' => $params["username"],
            'package' => $params['configoption5']
        ];

        $params = getParams($params);

        $results = camp_directadmin_directadmin_request($command, $fields, $params, true);
        return $results['errors'] == 0 ? true : $results['message'];


    } catch (Exception $e) {

        return $e->getMessage();
    }

}

function camp_directadmin_ClientAreaCustomButtonArray()
{

    return [
        "RebootServer" => "reboot",
    ];

}

function camp_directadmin_reboot($params)
{


    return true;

}

function camp_directadmin_ClientArea($vars)
{


    $params = getParams($vars);

    $data = camp_directadmin_directadmin_request('CMD_API_SHOW_USER_USAGE', $vars['username'], $params);

    return [
        'templatefile' => 'usage',
        'vars' => array_merge($vars, $data),
    ];

}

/**
 * @param $vars
 * @return array
 */
function getParams($vars): array
{
    $params["serverhostname"] = $vars["configoption1"];
    $params["serverusername"] = $vars["configoption3"];
    $params["serverpassword"] = $vars["configoption4"];
    $params["serverhttpprefix"] = 'https';
    $params["serverport"] = $vars["configoption2"];
    return $params;
}

function camp_directadmin_directadmin_request($command, $fields, $params, $post = "")
{
    $host = $params["serverhostname"] ? $params["serverhostname"] : $params["serverip"];
    $user = $params["serverusername"];
    $pass = $params["serverpassword"];
    $httpprefix = $params["serverhttpprefix"];
    $port = $params["serverport"];
    $resultsarray = array();
    $fieldstring = "";
    foreach ($fields as $key => $value) {
        $fieldstring .= (string)$key . "=" . urlencode($value) . "&";
    }
    $url = $httpprefix . "://" . $host . ":" . $port . "/" . $command;
    if (!$post) {
        $url .= "?" . $fieldstring;
    }
    $authstr = $user . ":" . $pass;
    $directadminaccterr = "";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_URL, $url);
    if ($post) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldstring);
    }
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $curlheaders[0] = "Authorization: Basic " . base64_encode($authstr);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $curlheaders);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    $data = curl_exec($ch);
    if (curl_errno($ch)) {
        $resultsarray["error"] = true;
        $resultsarray["details"] = curl_errno($ch) . " - " . curl_error($ch);
        $data = curl_errno($ch) . " - " . curl_error($ch);
    }
    curl_close($ch);
    $arrayReturnPackages = array("CMD_API_PACKAGES_RESELLER", "CMD_API_PACKAGES_USER", "CMD_API_ADDITIONAL_DOMAINS", "CMD_API_SHOW_ALL_USERS", "CMD_API_SHOW_USERS", "CMD_API_SHOW_RESELLERS");
    if (!$resultsarray["error"]) {
        if (strpos($data, "DirectAdmin Login") == true) {
            $resultsarray = array("error" => "1", "details" => "Login Failed");
        } else {
            if (strpos($data, "Your IP is blacklisted") !== false) {
                $resultsarray = array("error" => "1", "details" => "WHMCS Host Server IP is Blacklisted");
            } else {
                if ($params["getip"]) {
                    $data2 = camp_directadmin_directadmin_unhtmlentities($data);
                    parse_str($data2, $output);
                    foreach ($output as $key => $value) {
                        $key = str_replace("_", ".", urldecode($key));
                        $value = explode("&", urldecode($value));
                        foreach ($value as $temp) {
                            $temp = explode("=", $temp);
                            $resultsarray[urldecode($key)][$temp[0]] = $temp[1];
                        }
                    }
                } else {
                    if (in_array($command, $arrayReturnPackages)) {
                        $data2 = camp_directadmin_directadmin_unhtmlentities($data);
                        parse_str($data2, $resultsarray);
                    } else {
                        $data = explode("&", $data);
                        foreach ($data as $temp) {
                            $temp = explode("=", $temp);
                            $temp[0] = urldecode($temp[0]);
                            $temp[1] = urldecode($temp[1]);
                            $resultsarray[$temp[0]] = $temp[1];
                        }
                    }
                }
            }
        }
    }

    return $resultsarray;
}

function camp_directadmin_directadmin_unhtmlentities($string)
{
    return preg_replace_callback("~&#([0-9][0-9])~", function ($match) {
        return chr($match[1]);
    }, $string);
}




