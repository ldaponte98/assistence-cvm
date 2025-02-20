<?php
namespace App\Shared;

use App\Models\ApplicationWebhook;
use App\External\Http;
use App\Shared\Log;
use Exception;

class ApplicationWebhookHandler
{
    const UPDATE_PEOPLE = "UPDATE_PEOPLE";

    public static function run($type, $data)
    {
        $selecteds = ApplicationWebhook::all()->where('type', $type)->where('status', 1);
        foreach ($selecteds as $selected) {
            try {
                $http = Http::post($selected->url, $data);
                Log::save("Se envia EXITOSAMENTE webhook [".$type."] a url: " . $selected->url . " con respuesta: " . json_encode($http->response));
            } catch (Exception $e) {
                Log::save("ERROR enviando webhook [".$type."] a url: " . $selected->url . " con respuesta: " . json_encode($http));
            }
        }
    }
}