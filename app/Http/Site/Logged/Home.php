<?php

namespace App\Http\Site\Logged;

use App\Entity\Auth\IdentityStorage;
use App\Helpers\Session;
use App\Http\Controller;
use App\Service\Register\UserService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class Home
 * @package App\Http\Site\Logged
 */
class Home extends Controller
{
    /**
     * @Inject
     *
     * @var Twig
     */
    private Twig $view;

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
     * @return ResponseInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index()
    {
        if (!Session::get('user')) {
            return $this->getResponse()->withHeader('Location', '/login');
        }

        return $this->view->render(
            $this->getResponse(),
            '@site/logged/index.twig'
        );
    }

    /**
     * @return ResponseInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function indexLogin()
    {
        return $this->view->render(
            $this->getResponse(),
            '@site/login/index.twig'
        );
    }

    /**
     * @return ResponseInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function indexRegister()
    {
        return $this->view->render(
            $this->getResponse(),
            '@site/register/index.twig'
        );
    }

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
        if (!Session::get('user')) {
            return $this->getResponse()->withHeader('Location', '/login');
        }

        Session::destroy();
        return $this->getResponse()->withHeader('Location', '/login');
    }
}
