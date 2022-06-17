<?php

namespace App\Service\Rom;

use App\Entity\Rom\RomEntity;
use App\Repository\Rom\RomRepository;
use App\Service\Service;

class RomService extends Service
{
    public function insert($params)
    {
        $this->beginTransaction();

        try {
            $rom = new RomEntity();

            $rom->name = $params['name'];
            $rom->platform_id = (int)$params['platforms'];
            $rom->developer = $params['developer'];
            $rom->publisher = $params['publisher'];
            $rom->series = $params['series'];
            $rom->release = $params['release'];
            $rom->mode = $params['mode'];

            $rom->save();
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
            $rom = $this->getFromId($params['id']);

            $rom->name = $params['name'];
            $rom->platform_id = $params['platforms'];
            $rom->developer = $params['developer'];
            $rom->publisher = $params['publisher'];
            $rom->series = $params['series'];
            $rom->release = $params['release'];
            $rom->mode = $params['mode'];

            $rom->save();
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

    protected function getRepositoryClass(): string
    {
        return RomRepository::class;
    }
}
