<?php

namespace App\Service\Platform;

use App\Entity\Platform\PlatformEntity;
use App\Helpers\Session;
use App\Repository\Platform\PlatformRepository;
use App\Service\Service;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use ReflectionException;
use Throwable;

/**
 * Class PlatformService
 * @package App\Service\Platform
 */
class PlatformService extends Service
{
    /**
     * @param $params
     * @return bool
     * @throws Throwable
     */
    public function insert($params)
    {
        if (!$params['name'] ||
            !$params['developer'] ||
            !$params['generation'] ||
            !$params['release_jp'] ||
            !$params['release_us'] ||
            !$params['release_br'] ||
            !$params['media_type']
        ) {
            return false;
        }

        $release_dates = [$params['release_jp'], $params['release_us'], $params['release_br']];

        if (!$this->validateDates($release_dates)) {
            return false;
        }

        $this->beginTransaction();

        try {
            $platform = new PlatformEntity();
            $this->setPlatformAttributes($platform, $params);
            $platform->save();
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
            !$params['developer'] ||
            !$params['generation'] ||
            !$params['release_jp'] ||
            !$params['release_us'] ||
            !$params['release_br'] ||
            !$params['media_type']
        ) {
            return false;
        }

        $release_dates = [$params['release_jp'], $params['release_us'], $params['release_br']];

        if (!$this->validateDates($release_dates)) {
            return false;
        }

        $this->beginTransaction();

        try {
            $platform = $this->getFromId($params['id']);
            $this->setPlatformAttributes($platform, $params);
            $platform->save();
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
            //error_log($e);
            Session::set('error_detail', $e->getMessage());
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
    public function getByName($name)
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
     * @return mixed
     * @throws ReflectionException
     * @throws Exception
     */
    public function getNameAll()
    {
        $data = $this->getRepository()->getNameAll();

        if (!$data) {
            throw new Exception();
        }

        return $data;
    }

    /**
     * @param $platform
     * @param $params
     */
    private function setPlatformAttributes($platform, $params) {
        $platform->name = $params['name'];
        $platform->user_id = Session::get('user_id');
        $platform->developer = $params['developer'];
        $platform->generation = $params['generation'];
        $platform->release_jp = $params['release_jp'];
        $platform->release_us = $params['release_us'];
        $platform->release_br = $params['release_br'];
        $platform->media_type = $params['media_type'];
    }

    /**
     * @param array $dates
     * @return bool
     */
    private function validateDates(Array $dates) {
        foreach ($dates as $date) {
            if (Carbon::parse($date)->format('Y-m-d') > Carbon::now()->format('Y-m-d')) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return string
     */
    protected function getRepositoryClass(): string
    {
        return PlatformRepository::class;
    }
}
