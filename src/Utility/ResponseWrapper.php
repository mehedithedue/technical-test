<?php


namespace Utility;


class ResponseWrapper
{
    public static function successResponse($data)
    {
        http_response_code(200);

        echo json_encode([
            'status' => 'success',
            'data' => $data,
            'message' => null
        ]);
        return null;
    }

    public static function validationErrorResponse($messages)
    {
        return self::errorResponse($messages, 422);
    }

    public static function errorResponse($messages, $statusCode = 404)
    {
        http_response_code($statusCode);

        echo json_encode([
            'status' => 'error',
            'data' => null,
            'message' => $messages
        ]);

        return null;
    }

}