<?php


namespace App\Models\Traits;


trait ResponseTrait
{
    static public function responseJson($attr, $message, int $code = 200) {
        return response()->json(["data" => $attr, "message" => $message], $code);
    }
}
