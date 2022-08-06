<?php

namespace App\Http\Site\Logged;

use App\Http\Controller;
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

    public function indexRegister()
    {
        return $this->view->render(
            $this->getResponse(),
            '@site/register/index.twig'
        );
    }

    public function login()
    {
        $params = $this->getRequest()->getParsedBody();

        if (!$params) {
            return new HttpBadRequestException($this->getRequest());
        }
    }
}
