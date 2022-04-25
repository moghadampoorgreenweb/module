<?php
namespace fellingCustomer\Responses;
class Responses
{
    public static function updateResponse()
    {
        http_response_code(202);
        return json_encode([
            'success' => [
                'status' => 'update',
                'details' => 'Ticket Was Update Felling Customer'
            ]
        ]);

    }

    public static function unsuccessResponse()
    {
        http_response_code(404);
        return json_encode([
            'Unsuccessful' => [
                'status' => 'Unsuccessful',
                'details' => 'Ticket Was Not Save'
            ]
        ]);

    }

    public static function successResponse()
    {
        http_response_code(201);
        return json_encode([
            'success' => [
                'status' => 'create',
                'details' => 'Ticket Was Save Felling Customer'
            ]
        ]);

    }
}

