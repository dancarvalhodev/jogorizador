<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

/**
 * Class Session.
 *
 * @author  Jerfeson Guerreiro <jerfeson_guerreiro@hotmail.com>
 *
 * @since   1.0.0
 *
 * @version 3.0.0
 */
class Session
{
    public function __invoke(Request $request, RequestHandler $handler)
    {
        if (session_status() !== 2) {
            session_start();
        }

        return $handler->handle($request);
    }
}
