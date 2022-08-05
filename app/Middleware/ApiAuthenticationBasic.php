<?php

namespace App\Middleware;

use App\Entity\Auth\IdentityStorage;
use App\Repository\Register\UserRepository;
use App\Repository\RepositoryManager;
use App\Routing\ApiRouteResolver;
use App\Service\RouteFinder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use ReflectionException;
use Slim\Exception\HttpUnauthorizedException;

/**
 * Class ApiAuthenticationBasic
 * @package App\Middleware
 */
class ApiAuthenticationBasic implements MiddlewareInterface
{
    private IdentityStorage $storage;
    private RepositoryManager $repositoryManager;
    private ApiRouteResolver $apiResolver;
    private RouteFinder $routeFinder;

    /**
     * @param RouteFinder       $routeFinder
     * @param ApiRouteResolver  $apiResolver
     * @param IdentityStorage   $storage
     * @param RepositoryManager $repository
     */
    public function __construct(
        RouteFinder $routeFinder,
        ApiRouteResolver $apiResolver,
        IdentityStorage $storage,
        RepositoryManager $repository
    ) {
        $this->storage = $storage;
        $this->repositoryManager = $repository;
        $this->routeFinder = $routeFinder;
        $this->apiResolver = $apiResolver;
    }

    /**
     * @param Request $request
     * @param RequestHandler $handler
     *
     * @return ResponseInterface
     * @throws HttpUnauthorizedException
     * @throws ReflectionException
     */
    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {
        if (!$request->hasHeader('Authorization')) {
            throw new HttpUnauthorizedException($request);
        }

        $this->setUpStorage($request);
        return $handler->handle($request);
    }

    /**
     * @param Request $request
     *
     * @throws ReflectionException
     * @throws HttpUnauthorizedException
     */
    private function setUpStorage(Request $request)
    {
        $userRepo = $this->repositoryManager->get(UserRepository::class);

        $user = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : null;
        $pass = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : null;
        $user = $userRepo->getUserEntityByCredentials(['username' => $user, 'password' => $pass]);

        if (!$user) {
            throw new HttpUnauthorizedException($request);
        }

        $this->storage->setUser($user);
    }

}
