<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SimpleApi
{
    public function handle($request, Closure $next)
	{
	 			

		if($request->header('access-token') !== 'a1a09df74a235deee6db95a9511a728fc9812dd2'){			
			return response('Token inválido.', 403);
		}	

		$response = $next($request)
			->header('Access-Control-Allow-Origin', '*')
			->header('Access-Control-Allow-Credentials', 'true')
			->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, PATCH, DELETE')
			->header('Access-Control-Allow-Headers', 'Access-Control-Allow-Headers, Origin, Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Authorization, Access-Control-Request-Headers, Token');        

		return $response;	


	}
}
