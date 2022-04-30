<?php
include_once __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/Models/Model.php';
include_once __DIR__ . '/Controllers/ModuleController.php';
include_once __DIR__ . '/Helpers/HelperModule.php';
include_once __DIR__ . '/Response/Response.php';


add_hook('TicketOpen', 1, function ($vars) {

    if ($vars['deptname'] == 'پشتیبانی' && $vars['deptid'] == 2) {
        new \tiket_module\Controllers\ModuleController(null);
    }
});


add_hook('AdminSupportTicketPagePreTickets', 1, function ($vars) {
    $controller = new \tiket_module\Controllers\ModuleController(null);
    return $controller->getView();
});




