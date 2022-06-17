<?php

namespace App\Http\Site\Logged;

use App\Helpers\Session;
use App\Http\Controller;
use App\Service\Platform\PlatformService;
use DI\Annotation\Inject;
use Slim\Views\Twig;

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

    public function insertForm()
    {
        return $this->view->render(
            $this->getResponse(),
            '@site/logged/crud/platform/insertForm.twig'
        );
    }

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
                    'release_jp' => date('Y-m-d', strtotime($return->release_jp)),
                    'release_us' => date('Y-m-d', strtotime($return->release_us)),
                    'release_br' => date('Y-m-d', strtotime($return->release_br)),
                    'media_type' => $return->media_type,
                ]
            );
        }

        return $this->getResponse()->withHeader('Location', '/');
    }

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
                    'release_jp' => date('Y-m-d', strtotime($return->release_jp)),
                    'release_us' => date('Y-m-d', strtotime($return->release_us)),
                    'release_br' => date('Y-m-d', strtotime($return->release_br)),
                    'media_type' => $return->media_type,
                ]
            );
        }

        return $this->getResponse()->withHeader('Location', '/');
    }

    public function showPlatforms()
    {
        $return = $this->platformService->getAll();
        $status = Session::get('status');
        $type = Session::get('type');

        Session::delete('status');
        Session::delete('type');

        if ($return) {
            return $this->view->render(
                $this->getResponse(),
                '@site/logged/crud/platform/showPlatforms.twig',
                [
                    'data' => $return,
                    'status' => $status,
                    'type' => $type
                ]
            );
        }

        return $this->getResponse()->withHeader('Location', '/');
    }

    public function deletePlatform()
    {
        $id = (int)$this->getRequest()->getAttribute('id') ?? null;

        if ($id) {
            $return = $this->platformService->delete($id);

            if ($return) {
                echo 'Deleted';
                exit;
            }

            return $this->getResponse()->withHeader('Location', '/');
        }

        return $this->getResponse()->withHeader('Location', '/');
    }

    public function insert()
    {
        $params = $this->getRequest()->getParsedBody();
        $return = $this->platformService->insert($params);

        Session::set('type', ['Inserted', 'insert']);

        if ($return) {
            Session::set('status', true);
            return $this->getResponse()->withHeader('Location', '/show/platform/all');
        }

        Session::set('status', false);
        return $this->getResponse()->withHeader('Location', '/');
    }

    public function update()
    {
        $params = $this->getRequest()->getParsedBody();
        $return = $this->platformService->update($params);

        Session::set('type', ['Updated', 'update']);

        if ($return) {
            Session::set('status', true);
            return $this->getResponse()->withHeader('Location', '/show/platform/all');
        }

        return $this->getResponse()->withHeader('Location', '/');
    }
}
