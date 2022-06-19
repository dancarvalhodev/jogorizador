<?php


namespace App\Payload\Consult;

use App\Payload\PayloadInterface;
use Illuminate\Database\Eloquent\Collection;

class PlatformPayload implements PayloadInterface
{
    /**
     * @var Collection
     */
    private Collection $platform;

    public function __construct(Collection $platform)
    {
        $this->platform = $platform;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            $this->platform
        ];
    }
}
