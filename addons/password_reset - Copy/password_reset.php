<?php

//use Illuminate\Database\Capsule;
//use WHMCS\Module\Addon\AddonModule\Client\ClientDispatcher;
use Illuminate\Database\Capsule\Manager as Capsule;



function password_reset_activate()
{

    // Create custom tables and schema required by your module
    try {

        if (Capsule::table('password_reset')) {
            Capsule::schema()
                ->create(
                    'password_reset',
                    function ($table) {
                        /** @var \Illuminate\Database\Schema\Blueprint $table */
                        $table->increments('id');
                        $table->boolean('is_active');
                        $table->timestamps();
                    }
                );
        }
        Capsule::table('password_reset')->insert([
            'is_active' => true,
            'created_at' =>date("Y-m-d H:i:s"),
        ]);
        return [
            // Supported values here include: success, error or info
            'status' => 'success',
            'description' => 'This is a demo module only. '
                . 'In a real module you might report a success or instruct a '
                . 'user how to get started with it here.',
        ];
    } catch (\Exception $e) {
        return [
            // Supported values here include: success, error or info
            'status' => "error",
            'description' => 'Unable to create mod_addonexample: ' . $e->getMessage(),
        ];
    }
}


function password_reset_output($vars)
{

    $module = $vars['modulelink'];

   // $users = localAPI('GetClients');

            include __DIR__ ."/view/module.php";

    // echo '<p>The date & time are currently ' . date("Y-m-d H:i:s") . '</p>';

}



function password_reset_config()
{
    return [
        // Display name for your module
        'name' => 'password_reset',
        // Description displayed within the admin interface

        'fields' => [
            // a text field type allows for single line text input
            'Text Field Name' => [
                'FriendlyName' => 'Text Field Name',
                'Type' => 'text',
                'Size' => '25',
                'Default' => 'Default value',
                'Description' => 'Description goes here',
            ],
            // a password field type allows for masked text input
            'Password Field Name' => [
                'FriendlyName' => 'Password Field Name',
                'Type' => 'password',
                'Size' => '25',
                'Default' => '',
                'Description' => 'Enter secret value here',
            ],
            // the yesno field type displays a single checkbox option
            'Checkbox Field Name' => [
                'FriendlyName' => 'Checkbox Field Name',
                'Type' => 'yesno',
                'Description' => 'Tick to enable',
            ],
        ]
    ];
}




function password_reset_clientarea($vars)
{
    return array(
        'pagetitle' => 'password_reset',
        'breadcrumb' => array('index.php?m=password_reset'=>'password_reset'),
        'templatefile' => 'login',
        'requirelogin' => true, # accepts true/false
        'forcessl' => false, # accepts true/false
        'vars' => array(
            'testvar' => 'password_reset',
            'anothervar' => 'value',
            'sample' => 'password_reset',
        ),
    );
}

