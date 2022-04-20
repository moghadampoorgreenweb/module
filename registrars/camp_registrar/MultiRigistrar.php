<?php

class MultiRigistrar
{


    private Api $api;


    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    public function register($domain, $contact, $dnsList, $period)
    {
        $data = [
            'domain' => $domain,
            'period' => $period,
            'dnsList' => $dnsList,
            'contact' => $contact,
        ];


        return $this->api->post('domain/register', $data);
    }

    public function transfer($domain, $eppcode, $contact, $dnsList, $period)
    {

        $data = [
            'domain' => $domain,
            'epp' => $eppcode,
            'period' => $period,
            'dnsList' => $dnsList,
            'contact' => $contact,
        ];

        return $this->api->post("domain/transfer", $data);
    }

    public function renew($domain, $period)
    {
        $data = [
            'period' => $period,
        ];

        return $this->api->put("domain/$domain/renew", $data);
    }

    public function changeDns($domain, $dns)
    {
        $data = [
            'dnsList' => $dns,
        ];

        return $this->api->put("/domain/$domain/dns", $data);
    }

    public function lock($domain, $lockenabled)
    {
        $data = [
            'status' => $lockenabled=='locked'?$lockenabled='lock':$lockenabled='unlock',
        ];

        return $this->api->put("/domain/$domain/$lockenabled", $data);
    }
    public function RegisterNameserver($domain, $data)
    {
        $data = [
            'domain'=>$domain,
            'ns' => $data['nameserver'],
            'ip'=>$data['ipaddress']
        ];

        return $this->api->post("/domain/$domain/child", $data);
    }
    public function ModifyNameserver($domain, $data)
    {
        $data = [
            'domain'=>$domain,
            'ns' => $data['nameserver'],
            'ip'=>$data['newipaddress']
        ];

        return $this->api->put("/domain/$domain/child", $data);
    }
    public function DeleteNameserver($domain,$data)
    {
        $data = [
            'domain'=>$domain,
            'ns' => $data['nameserver'],
            'ip'=>$data['ipaddress']
        ];
        return $this->api->delete("/domain/$domain/child",$data);
    }
    public function DeleteReservedwords($domain,$data)
    {
        $data = [
            'domain'=>$domain,
            'ns' => $data['nameserver'],
            'ip'=>$data['ipaddress']
        ];
        return $this->api->delete("/domain/$domain/child",$data);
    }
    public function savecontactdetails($domain, $contact)
    {
        $params = [
            'contacts' => [
                'holder'=> $contact,
            ],
        ];
        return $this->api->put("/domain/$domain/contacts", $params);
    }
    public function whois($domain)
    {
        return $this->api->get("/domain/$domain", null);
    }

    public function singleInfo($domain, $period)
    {
        $data = [
            'period' => $period,
        ];

        return $this->api->get("/setting/contact-info", $data);

    }

    public function epp($domain = null)
    {
        $trackID = 507982;
        //   $output = $this->api->get("domain/$domain/epp", $data);
        return $this->api->get("/manage/inquiry/$trackID");

    }

}