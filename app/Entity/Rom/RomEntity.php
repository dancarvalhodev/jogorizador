<?php

namespace App\Entity\Rom;

use App\Entity\Entity;
use App\Entity\Platform\PlatformEntity;

class RomEntity extends Entity
{
    protected $table = 'roms';

    public function rom()
    {
        return $this->hasMany(PlatformEntity::class, 'id', 'platform_id');
    }
}
