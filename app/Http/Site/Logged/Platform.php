<?php

namespace App\Http\Site\Logged;

use App\Helpers\Session;
use App\Http\Controller;
use App\Service\Platform\PlatformService;
use Carbon\Carbon;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;
use Slim\Views\Twig;
use Throwable;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class Platform
 * @package App\Http\Site\Logged
 */
class Platform extends Controller
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
     * @var PlatformService
     */
    private PlatformService $platformService;

    /**
     * @return ResponseInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function insertForm()
    {
        return $this->view->render(
            $this->getResponse(),
            '@site/logged/crud/platform/insertForm.twig'
        );
    }

    /**
     * @return ResponseInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function deleteForm()
    {
        $id = (int)$this->getRequest()->getAttribute('id') ?? null;

        if ($id) {
            return $this->view->render(
                $this->getResponse(),
                '@site/logged/crud/platform/deleteForm.twig',
                [
                    'id' => $id,
                ]
            );
        }

        return $this->getResponse()->withHeader('Location', '/');
    }

    /**
     * @return ResponseInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws ReflectionException
     */
    public function updateForm()
    {
        $id = (int)$this->getRequest()->getAttribute('id') ?? null;

        if ($id) {
            $return = $this->platformService->getFromId($id);

            return $this->view->render(
                $this->getResponse(),
                '@site/logged/crud/platform/updateForm.twig',
                [
                    'id' => $return->id,
                    'name' => $return->name,
                    'developer' => $return->developer,
                    'generation' => $return->generation,
                    'release_jp' => Carbon::parse(strtotime($return->release_jp))->format('Y-m-d'),
                    'release_us' => Carbon::parse(strtotime($return->release_us))->format('Y-m-d'),
                    'release_br' => Carbon::parse(strtotime($return->release_br))->format('Y-m-d'),
                    'media_type' => $return->media_type,
                ]
            );
        }

        return $this->getResponse()->withHeader('Location', '/');
    }

    /**
     * @return ResponseInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws ReflectionException
     */
    public function showPlatform()
    {
        $id = (int)$this->getRequest()->getAttribute('id') ?? null;

        if ($id) {
            $return = $this->platformService->getFromId($id);

            return $this->view->render(
                $this->getResponse(),
                '@site/logged/crud/platform/showPlatform.twig',
                [
                    'id' => $return->id,
                    'name' => $return->name,
                    'developer' => $return->developer,
                    'generation' => $return->generation,
                    'release_jp' => Carbon::parse(strtotime($return->release_jp))->format('d/m/Y'),
                    'release_us' => Carbon::parse(strtotime($return->release_us))->format('d/m/Y'),
                    'release_br' => Carbon::parse(strtotime($return->release_br))->format('d/m/Y'),
                    'media_type' => $return->media_type,
                ]
            );
        }

        return $this->getResponse()->withHeader('Location', '/');
    }

    /**
     * @return ResponseInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws ReflectionException
     */
    public function showPlatforms()
    {
        $return = $this->platformService->getAll();
        $status = Session::get('status');
        $type = Session::get('type');
        $errorDetail = Session::get('error_detail');

        Session::delete('status');
        Session::delete('type');
        Session::delete('error_detail');

        if ($return) {
            foreach ($return as $item) {
                $item->release_jp = Carbon::parse(strtotime($item->release_jp))->format('d/m/Y');
                $item->release_us = Carbon::parse(strtotime($item->release_us))->format('d/m/Y');
                $item->release_br = Carbon::parse(strtotime($item->release_br))->format('d/m/Y');
            }

            return $this->view->render(
                $this->getResponse(),
                '@site/logged/crud/platform/showPlatforms.twig',
                [
                    'data' => $return,
                    'status' => $status,
                    'type' => $type,
                    'error' => $errorDetail
                ]
            );
        }

        return $this->getResponse()->withHeader('Location', '/');
    }

    /**
     * @return ResponseInterface
     * @throws Throwable
     */
    public function insert()
    {
        $params = $this->getRequest()->getParsedBody();
        $return = $this->platformService->insert($params);

        Session::set('type', ['Platform Inserted successfully', 'Failed to insert Platform']);

        if ($return) {
            Session::set('status', true);
            return $this->getResponse()->withHeader('Location', '/show/platform/all');
        }

        Session::set('status', false);
        return $this->getResponse()->withHeader('Location', '/show/platform/all');
    }

    /**
     * @return ResponseInterface
     * @throws Throwable
     */
    public function update()
    {
        $params = $this->getRequest()->getParsedBody();
        $return = $this->platformService->update($params);

        Session::set('type', ['Platform Updated successfully', 'Failed to update Platform']);

        if ($return) {
            Session::set('status', true);
            return $this->getResponse()->withHeader('Location', '/show/platform/all');
        }

        Session::set('status', false);
        return $this->getResponse()->withHeader('Location', '/show/platform/all');
    }

    /**
     * @return ResponseInterface
     * @throws Throwable
     */
    public function delete()
    {
        $params = $this->getRequest()->getParsedBody();
        $return = $this->platformService->delete($params);

        Session::set('type', ['Platform Deleted successfully', 'Failed to delete platform or operation canceled by user']);

        if ($return) {
            Session::set('status', true);
            return $this->getResponse()->withHeader('Location', '/show/platform/all');
        }

        Session::set('status', false);
        return $this->getResponse()->withHeader('Location', '/show/platform/all');
    }
}
