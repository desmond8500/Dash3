<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResponseController extends Controller
{

    /**
     * Reponse API
     *
     * @param boolean $success Description
     * @param string $message Message
     * @param array $data Donnnnées à retourner
     * @return type
     * @throws conditon
     **/
    public static function response($success, $message, $data = null, $meta = null)
    {
        if ($success) {
            $response = [
                'success' => $success,
                'message' => $message,
                'data' => $data,
                'meta' => $meta,
            ];
        } else {
            $response = [
                'success' => $success,
                'message' => $message,
                'error' => $data,
                'meta' => $meta,
            ];
        }

        if ($success) {
            $code = 200;
        } else {
            $code = 400;
        }

        return response()->json($response, $code);
    }

    static function validation($request, $validate, $message = "Error")
    {
        try {
            $request->validate($validate);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $message,
                'errors' => $e->errors(),
            ], 422);
        }
    }
}
