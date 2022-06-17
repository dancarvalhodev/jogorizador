<?php

namespace App\Entity\Rom;

use App\Entity\Entity;
use App\Entity\Platform\PlatformEntity;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class RomEntity
 * @package App\Entity\Rom
 */
class RomEntity extends Entity
{
    /**
     * @var string
     */
    protected $table = 'roms';

    /**
     * @return HasMany
     */
    public function rom()
    {
        return $this->hasMany(PlatformEntity::class, 'id', 'platform_id');
    }
}
