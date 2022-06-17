<?php

namespace App\Repository\Rom;

use App\Entity\Rom\RomEntity;
use App\Repository\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class RomRepository
 * @package App\Repository\Rom
 */
class RomRepository extends Repository
{
    /**
     * @param $id
     * @return mixed
     */
    public function getFromId($id)
    {
        $queryBuilder = $this->newQuery();
        $queryBuilder->select('platforms.name as platform_name', 'platforms.id as platform_id', 'roms.id', 'roms.name as rom_name', 'roms.developer', 'roms.publisher', 'roms.series', 'roms.mode', 'roms.release');
        $queryBuilder->join('platforms', 'platforms.id', '=', 'roms.platform_id');
        $queryBuilder->where('roms.id', $id);

        return $queryBuilder->get()->first();
    }

    /**
     * @return Builder[]|Collection
     */
    public function getAll()
    {
        $queryBuilder = $this->newQuery();
        $queryBuilder->select('platforms.name as platform_name', 'platforms.id as platform_id', 'roms.id', 'roms.name as rom_name', 'roms.developer', 'roms.publisher', 'roms.series', 'roms.mode', 'roms.release');
        $queryBuilder->join('platforms', 'platforms.id', '=', 'roms.platform_id');

        return $queryBuilder->get();
    }

    /**
     * @return string
     */
    public function getEntityClass(): string
    {
        return RomEntity::class;
    }
}
