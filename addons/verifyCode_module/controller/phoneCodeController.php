<?php
include_once __DIR__ . '/../Helper/Helper.php';

class phoneCodeController extends mainController
{

    private $data;
    private $helper;


    public function __construct()
    {

        $this->helper = new \verifyCode_module\Helper\Helper();
        $this->data=$this->helper->getClients();
    }


    public function phoneNumber()
    {
        $this->proccess();
        return array(
            'pagetitle' => 'Addon Module',
            'breadcrumb' => array('index.php?m=verifyCode_module' => 'orderVm'),
            'templatefile' => 'phoneNumber',
            'requirelogin' => false, # accepts true/false
            'forcessl' => false, # accepts true/false

        );

    }

    public function proccess()
    {
        $data = $this->getData();

        dd($this->helper->wherePhoneClient($_REQUEST['number']));



    }

    public function codeNumber()
    {

        return array(
            'pagetitle' => 'Addon Module',
            'breadcrumb' => array('index.php?m=verifyCode_module' => 'orderVm'),
            'templatefile' => 'codeNumber',
            'requirelogin' => false, # accepts true/false
            'forcessl' => false, # accepts true/false

        );

    }


    public function index()
    {
        var_dump('dddd');
        die;
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