<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
	
    public function handle($request, Closure $next)
	{
	 
		
		$response = $next($request);
		$IlluminateResponse = 'Illuminate\Http\Response';
		$SymfonyResopnse = 'Symfony\Component\HttpFoundation\Response';
		$headers = [
		    'Access-Control-Allow-Origin' => '*',
		    'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, PATCH, DELETE',
		    'Access-Control-Allow-Headers' => 'Access-Control-Allow-Headers, Origin, Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Authorization, Access-Control-Request-Headers, access-token',
		];
		
	    foreach ($headers as $key => $value) {
	        $response->headers->set($key, $value);
	    }
	    return $response;
		
	}
}
