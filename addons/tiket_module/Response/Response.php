<?php

namespace tiket_module\Response;

class Response
{
    public static function success()
    {
        return [
            'status'=>201,
        ];
    }
    public static function getTickets()
    {

        return   (localAPI('GetTickets'))['tickets']['ticket'];
    }
    public static function getAdmin()
    {

        return    (localAPI('GetAdminUsers'))['admin_users'];
    }
     public static function getTicket($idTicket)
     {
         $postData = array(
             'ticketid' => $idTicket,
         );
         $results = localAPI('GetTicket', $postData);

         return    ($results);
     }

}