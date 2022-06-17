<?php

namespace App\Service\Platform;

use App\Entity\Platform\PlatformEntity;
use App\Repository\Platform\PlatformRepository;
use App\Service\Service;

class PlatformService extends Service
{

    public function insert($params)
    {
        $this->beginTransaction();

        try {
            $platform = new PlatformEntity();

            $platform->name = $params['name'];
            $platform->developer = $params['developer'];
            $platform->generation = $params['generation'];
            $platform->release_jp = $params['release_jp'];
            $platform->release_us = $params['release_us'];
            $platform->release_br = $params['release_br'];
            $platform->media_type = $params['media_type'];

            $platform->save();
            $this->commit();

            return true;
        } catch (\Throwable $e) {
            error_log($e);
            $this->rollBack();
            return false;
        }
    }

    public function update($params)
    {
        $this->beginTransaction();

        try {
            $platform = $this->getFromId($params['id']);

            $platform->name = $params['name'];
            $platform->developer = $params['developer'];
            $platform->generation = $params['generation'];
            $platform->release_jp = $params['release_jp'];
            $platform->release_us = $params['release_us'];
            $platform->release_br = $params['release_br'];
            $platform->media_type = $params['media_type'];

            $platform->save();
            $this->commit();

            return true;
        } catch (\Throwable $e) {
            error_log($e);
            $this->rollBack();
            return false;
        }
    }

    public function delete($params)
    {
        if ($params['confirm'] === 'No') {
            return false;
        }

        $this->beginTransaction();

        try {
            $this->getFromId($params['id'])->delete();
            $this->commit();

            return true;
        } catch (\Throwable $e) {
            error_log($e);
            $this->rollBack();
            return false;
        }
    }

    public function getFromId($id)
    {
        $data = $this->getRepository()->getFromId($id);

        if (!$data) {
            throw new \Exception();
        }

        return $data;
    }

    public function getAll()
    {
        $data = $this->getRepository()->getAll();

        if (!$data) {
            throw new \Exception();
        }

        return $data;
    }

    public function getNameAll()
    {
        $data = $this->getRepository()->getNameAll();

        if (!$data) {
            throw new \Exception();
        }

        return $data;
    }

    protected function getRepositoryClass(): string
    {
        return PlatformRepository::class;
    }
}
