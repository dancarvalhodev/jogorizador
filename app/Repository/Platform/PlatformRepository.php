<?php

namespace App\Repository\Platform;

use App\Entity\Platform\PlatformEntity;
use App\Repository\Repository;

class PlatformRepository extends Repository
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

    public function getNameAll()
    {
        $queryBuilder = $this->newQuery();
        $queryBuilder->select('id', 'name');
        return $queryBuilder->get();
    }

    public function getEntityClass(): string
    {
        return PlatformEntity::class;
    }
}
