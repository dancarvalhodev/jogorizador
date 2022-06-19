<?php


namespace App\Payload\Consult;

use App\Payload\PayloadInterface;
use Illuminate\Database\Eloquent\Collection;

class RomPayload implements PayloadInterface
{
    /**
     * @var Collection
     */
    private Collection $rom;

    public function __construct(Collection $rom)
    {
        $this->rom = $rom;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            $this->rom
        ];
    }
}
