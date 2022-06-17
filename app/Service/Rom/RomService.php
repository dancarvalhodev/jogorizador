<?php

namespace App\Service\Rom;

use App\Entity\Rom\RomEntity;
use App\Repository\Rom\RomRepository;
use App\Service\Service;
use Exception;
use ReflectionException;
use Throwable;

/**
 * Class RomService
 * @package App\Service\Rom
 */
class RomService extends Service
{
    /**
     * @param $params
     * @return bool
     * @throws Throwable
     */
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
        } catch (Throwable $e) {
            error_log($e);
            $this->rollBack();
            return false;
        }
    }

    /**
     * @param $params
     * @return bool
     * @throws Throwable
     */
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
        } catch (Throwable $e) {
            error_log($e);
            $this->rollBack();
            return false;
        }
    }

    /**
     * @param $params
     * @return bool
     * @throws Throwable
     */
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
        } catch (Throwable $e) {
            error_log($e);
            $this->rollBack();
            return false;
        }
    }

    /**
     * @param $id
     * @return mixed
     * @throws ReflectionException
     * @throws Exception
     */
    public function getFromId($id)
    {
        $data = $this->getRepository()->getFromId($id);

        if (!$data) {
            throw new Exception();
        }

        return $data;
    }

    /**
     * @return mixed
     * @throws ReflectionException
     * @throws Exception
     */
    public function getAll()
    {
        $data = $this->getRepository()->getAll();

        if (!$data) {
            throw new Exception();
        }

        return $data;
    }

    /**
     * @return string
     */
    protected function getRepositoryClass(): string
    {
        return RomRepository::class;
    }
}
