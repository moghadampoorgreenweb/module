<?php

namespace tiket_module\Response;

class Response
{
    public static function success()
    {
        return [
            'status' => 201,
        ];
    }

    public static function getTickets()
    {

        return (localAPI('GetTickets'))['tickets']['ticket'];
    }

    public static function getAdmin()
    {

        return (localAPI('GetAdminUsers'))['admin_users'];
    }

    public static function getTicket($idTicket)
    {
        $postData = array(
            'ticketid' => $idTicket,
        );
        $results = localAPI('GetTicket', $postData);

        return ($results);
    }

    public static function updateTicket($idTicket, $flag)
    {
        $postData = array(
            'ticketid' => $idTicket,
            'flag' => $flag,
        );

        $results = localAPI('UpdateTicket', $postData);
        return $results;
    }

    public static function getDepartments()
    {
        return localAPI('GetSupportDepartments');
    }

    public static function getStaffOnline()
    {

        return  localAPI('GetStaffOnline');
    }


}