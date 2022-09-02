<?php

namespace App\Http\Site\Logged;

use App\Entity\Auth\IdentityStorage;
use App\Helpers\Session;
use App\Http\Controller;
use App\Service\Register\UserService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpBadRequestException;

/**
 * Class Base
 * @package App\Http\Site\Logged
 */
class Base extends Controller
{
    /**
     * @Inject
     *
     * @var UserService
     */
    private UserService $userService;

    /**
     * @Inject
     *
     * @var IdentityStorage
     */
    private IdentityStorage $storage;

    /**
     * @return ResponseInterface|HttpBadRequestException|void
     * @throws \ReflectionException
     */
    public function login()
    {
        $params = $this->getRequest()->getParsedBody();

        if (!$params) {
            return new HttpBadRequestException($this->getRequest());
        }

        $user = $this->userService->getRepository()->getUserEntityByCredentials($params);

        if ($user) {
            $this->storage->setUser($user);

            return $this->getResponse()->withHeader('Location', '/');
        }
    }

    /**
     * @return ResponseInterface|HttpBadRequestException|void
     * @throws \Throwable
     */
    public function register()
    {
        $params = $this->getRequest()->getParsedBody();

        if (!$params) {
            return new HttpBadRequestException($this->getRequest());
        }

        $response = $this->userService->register($params);

        if ($response) {
            return $this->getResponse()->withHeader('Location', '/login');
        }
    }

    /**
     * @return ResponseInterface
     */
    public function logout()
    {
        Session::destroy();
        return $this->getResponse()->withHeader('Location', '/login');
    }
}
