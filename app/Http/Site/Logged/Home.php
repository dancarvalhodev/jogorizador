<?php

namespace App\Http\Site\Logged;

use App\Http\Controller;
use DI\Annotation\Inject;
use Slim\Views\Twig;

class Home extends Controller
{
    /**
     * @Inject
     *
     * @var Twig
     */
    private Twig $view;

    public function index()
    {
        return $this->view->render(
            $this->getResponse(),
            '@site/logged/index.twig'
        );
    }
}
