<?php

namespace App\Repository\Rom;

use App\Entity\Rom\RomEntity;
use App\Repository\Repository;

class RomRepository extends Repository
{
    public function getFromId($id)
    {
        $queryBuilder = $this->newQuery();
        $queryBuilder->where('id', $id);

        return $queryBuilder->get()->first();
    }

    public function getAll()
    {
        $queryBuilder = $this->newQuery();
        return $queryBuilder->get();
    }

    public function getEntityClass(): string
    {
        return RomEntity::class;
    }
}
