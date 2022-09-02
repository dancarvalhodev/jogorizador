<?php

namespace App\Middleware;

use App\Helpers\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

/**
 *
 */
class AuthBasic
{
    /**
     * @param Request $request Request param.
     * @param RequestHandler $handler RequestHandler param.
     */
    public function __invoke(Request $request, RequestHandler $handler)
    {
        if (!Session::get('user')) {
            $response = new Response();
            return $response->withHeader('Location', '/login');
        }

        return $handler->handle($request);
    }
}
