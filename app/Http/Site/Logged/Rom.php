<?php

namespace App\Http\Site\Logged;

use App\Helpers\Session;
use App\Http\Controller;
use App\Service\Platform\PlatformService;
use App\Service\Rom\RomService;
use DI\Annotation\Inject;
use Slim\Views\Twig;

class Rom extends Controller
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
     * @var RomService
     */
    private RomService $romService;

    /**
     * @Inject
     *
     * @var PlatformService
     */
    private PlatformService $platformService;

    public function insertForm()
    {
        $platformData = $this->platformService->getNameAll();

        return $this->view->render(
            $this->getResponse(),
            '@site/logged/crud/rom/insertForm.twig',
            [
                'data' => $platformData
            ]
        );
    }

    public function deleteForm()
    {
        $id = (int)$this->getRequest()->getAttribute('id') ?? null;

        if ($id) {
            return $this->view->render(
                $this->getResponse(),
                '@site/logged/crud/rom/deleteForm.twig',
                [
                    'id' => $id,
                ]
            );
        }

        return $this->getResponse()->withHeader('Location', '/');
    }

    public function updateForm()
    {
        $id = (int)$this->getRequest()->getAttribute('id') ?? null;

        if ($id) {
            $return = $this->romService->getFromId($id);
            $platformData = $this->platformService->getNameAll();

            return $this->view->render(
                $this->getResponse(),
                '@site/logged/crud/rom/updateForm.twig',
                [
                    'data' => $platformData,
                    'id' => $return->id,
                    'name' => $return->name,
                    'platform' => $return->platform_id,
                    'developer' => $return->developer,
                    'publisher' => $return->publisher,
                    'series' => $return->series,
                    'release' => date('Y-m-d', strtotime($return->release)),
                    'mode' => $return->mode,
                ]
            );
        }

        return $this->getResponse()->withHeader('Location', '/');
    }

    public function showRom()
    {
        $id = (int)$this->getRequest()->getAttribute('id') ?? null;

        if ($id) {
            $return = $this->romService->getFromId($id);

            return $this->view->render(
                $this->getResponse(),
                '@site/logged/crud/rom/showRom.twig',
                [
                    'id' => $return->id,
                    'name' => $return->name,
                    'platform' => $return->platform_id,
                    'developer' => $return->developer,
                    'publisher' => $return->publisher,
                    'series' => $return->series,
                    'release' => date('Y-m-d', strtotime($return->release)),
                    'mode' => $return->mode,
                ]
            );
        }

        return $this->getResponse()->withHeader('Location', '/');
    }

    public function showRoms()
    {
        $return = $this->romService->getAll();
        $status = Session::get('status');
        $type = Session::get('type');
        $errorDetail = Session::get('error_detail');

        Session::delete('status');
        Session::delete('type');
        Session::delete('error_detail');

        if ($return) {
            return $this->view->render(
                $this->getResponse(),
                '@site/logged/crud/rom/showRoms.twig',
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

    public function insert()
    {
        $params = $this->getRequest()->getParsedBody();
        $return = $this->romService->insert($params);

        Session::set('type', ['Rom Inserted successfully', 'Failed to insert Rom']);

        if ($return) {
            Session::set('status', true);
            return $this->getResponse()->withHeader('Location', '/show/rom/all');
        }

        Session::set('status', false);
        return $this->getResponse()->withHeader('Location', '/show/rom/all');

    }

    public function update()
    {
        $params = $this->getRequest()->getParsedBody();
        $return = $this->romService->update($params);

        Session::set('type', ['Rom Updated successfully', 'Failed to update Rom']);

        if ($return) {
            Session::set('status', true);
            return $this->getResponse()->withHeader('Location', '/show/rom/all');
        }

        Session::set('status', false);
        return $this->getResponse()->withHeader('Location', '/show/rom/all');
    }

    public function delete()
    {
        $params = $this->getRequest()->getParsedBody();
        $return = $this->romService->delete($params);

        Session::set('type', ['Rom Deleted successfully', 'Failed to delete rom or operation canceled by user']);

        if ($return) {
            Session::set('status', true);
            return $this->getResponse()->withHeader('Location', '/show/rom/all');
        }

        Session::set('status', false);
        return $this->getResponse()->withHeader('Location', '/show/rom/all');
    }
}
