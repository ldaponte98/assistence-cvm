<?php

namespace App\External;

class Http
{
    public static function execute($method, $url, $request = null, $array_headers = [], $encode = true, $timeout = 120)
    {
        $response = null;
        $error    = true;
        $message  = "";

        $headers = "";
        if(!isset($array_headers["Content-Type"])) $array_headers["Content-Type"] = "application/json";
        if (count($array_headers) > 0) {
            foreach ($array_headers as $key => $value) {
                $headers .= $key . ":" . $value . " \r\n";
            }
        }
        try {
            $http = [
                "ssl"  => [
                    "verify_peer"      => false,
                    "verify_peer_name" => false,
                ],
                "http" => [
                    "method"        => $method,
                    "ignore_errors" => true,
                    "header"        => $headers,
                    'timeout'       => $timeout
                ],
            ];
            if($request != null){
                $http["http"]["content"] = $encode ? json_encode($request) : $request;
            }
            $context = stream_context_create($http);

            $response = file_get_contents($url, false, $context);
            //validamos el error
            $status_line = $http_response_header[0];

            preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);

            $status = $match[1];

            if ($status !== "200" and $status !== "201") {
                $message = $response;

            } else {

                $response = json_decode($response);
                $error    = false;
                $message  = "OK";
            }
        } catch (Exception $e) {

            $message = $e->getMessage();
        }

        return (object) [
            'message'  => $message,
            'response' => $response,
            'error'    => $error,
        ];
    }

    public static function get($url, $array_headers = [])
    {
        return Http::execute("GET", $url, null, $array_headers);
    }

    public static function post($url, $request = [], $array_headers = [], $encode = true, $timeout = 120)
    {
        return Http::execute("POST", $url, $request, $array_headers);
    }

    public static function delete($url, $request = null, $array_headers = [], $encode = true, $timeout = 120)
    {
        return Http::execute("DELETE", $url, $request, $array_headers);
    }

    public static function put($url, $request = [], $array_headers = [], $encode = true, $timeout = 120)
    {
        return Http::execute("PUT", $url, $request, $array_headers);
    }
}
