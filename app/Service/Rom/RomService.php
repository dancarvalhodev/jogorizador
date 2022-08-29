<?php

namespace App\Service\Rom;

use App\Entity\Rom\RomEntity;
use App\Helpers\Session;
use App\Repository\Rom\RomRepository;
use App\Service\Service;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
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
        if (!$params['name'] ||
            !$params['platforms'] ||
            !$params['developer'] ||
            !$params['publisher'] ||
            !$params['series'] ||
            !$params['release'] ||
            !$params['mode']
        ) {
            return false;
        }

        if (Carbon::parse($params['release'])->format('Y-m-d') > Carbon::now()->format('Y-m-d')) {
            return false;
        }

        $this->beginTransaction();

        try {
            $rom = new RomEntity();
            $this->setRomAttributes($rom, $params);
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
        if (!$params['id'] ||
            !$params['name'] ||
            !$params['platforms'] ||
            !$params['developer'] ||
            !$params['publisher'] ||
            !$params['series'] ||
            !$params['release'] ||
            !$params['mode']
        ) {
            return false;
        }

        $this->beginTransaction();

        try {
            $rom = $this->getFromId($params['id']);
            $this->setRomAttributes($rom, $params);
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
     * @param $name
     * @return array
     * @throws ReflectionException
     * @throws Exception
     */
    public function getByName($name): array
    {
        $data = $this->getRepository()->getByName($name);
        $dataArray = [];

        if (!$data) {
            throw new Exception();
        }

        foreach ($data as $item) {
            $dataArray[] = Collection::make($item);
        }

        return $dataArray;
    }

    /**
     * @param $rom
     * @param $params
     */
    private function setRomAttributes($rom, $params) {
        $rom->name = $params['name'];
        $rom->user_id = Session::get('user_id');
        $rom->platform_id = (int)$params['platforms'];
        $rom->developer = $params['developer'];
        $rom->publisher = $params['publisher'];
        $rom->series = $params['series'];
        $rom->release = $params['release'];
        $rom->mode = $params['mode'];
    }

    /**
     * @return string
     */
    protected function getRepositoryClass(): string
    {
        return RomRepository::class;
    }
}
