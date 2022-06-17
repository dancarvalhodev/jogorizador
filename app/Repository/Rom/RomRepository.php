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
        $queryBuilder->where('id', $id);

        return $queryBuilder->get()->first();
    }

    /**
     * @return Builder[]|Collection
     */
    public function getAll()
    {
        $queryBuilder = $this->newQuery();
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
