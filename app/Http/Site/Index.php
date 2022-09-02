<?php

namespace App\Http\Site;

use App\Entity\Auth\IdentityStorage;
use App\Http\Controller;
use App\Service\Register\UserService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class Base
 * @package App\Http\Site\Logged
 */
class Index extends Controller
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
}
