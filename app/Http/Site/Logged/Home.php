<?php

namespace App\Http\Site\Logged;

use App\Http\Controller;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;
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
    public function index()
    {
        return $this->view->render(
            $this->getResponse(),
            '@site/logged/index.twig'
        );
    }
}
