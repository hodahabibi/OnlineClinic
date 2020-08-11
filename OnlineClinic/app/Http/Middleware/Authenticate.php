<?php

namespace App\Http\Middleware;

use Closure;

//defining a username and password
define('USERNAME','hoda');
define('PASSWORD', '123456');

class Authenticate
{

    public function handle($request, Closure $next)
    {
        //getting values from headers
        //if the user is authenticated accepting the request
        if($request->header('PHP_AUTH_USER') == USERNAME && $request->header('PHP_AUTH_PW') == PASSWORD){
            return $next($request);

            //else displaying an unauthorized message
        }else{
            $content = array();
            $content['error'] = true;
            $content['message'] = 'Unauthorized Request';
            return response()->json($content, 401);
        }
    }
}
