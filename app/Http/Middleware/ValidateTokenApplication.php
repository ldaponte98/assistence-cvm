<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Shared\Util\Encryptor;

class ValidateTokenApplication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');
        $params = (object) $request->all();
        if($token == null && isset($params->key)) $token = $params->key;
        if($token == null || $token == "")
            return response()->json("Accedo denegado", 401);
        
        $decrypt = Encryptor::decrypt($token);
        if($decrypt == null)
            return response()->json("Token no valido", 498);

        $identity = null;
        try {
            $identity = json_decode($decrypt);
        } catch (\Throwable $th) {}

        if($identity == null)
            return response()->json("Invalid Token", 498);
        if(!isset($identity->id))
            return response()->json("ID unique invalid", 499);

        $current = date('Y-m-d H:i:s');
        if($identity->expired < $current)
            return response()->json("Expired Token", 402);
        $request->request->add(['identity' => $identity]);
        return $next($request);
    }
}
