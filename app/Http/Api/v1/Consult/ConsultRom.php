<?php

namespace App\Http\Api\v1\Consult;

use App\Http\Controller;
use App\Payload\CollectionPayload;
use App\Payload\Consult\PlatformPayload;
use App\Payload\Consult\RomPayload;
use App\Service\Rom\RomService;
use DI\Annotation\Inject;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;
use Slim\Exception\HttpBadRequestException;

class ConsultRom extends Controller
{
    /**
     * @Inject
     *
     * @var RomService
     */
    private RomService $romService;

    /**
     * @return ResponseInterface
     * @throws HttpBadRequestException
     * @throws ReflectionException
     * @throws Exception
     */
    public function getAction(): ResponseInterface
    {
        $params = $this->getRequest()->getQueryParams();

        if (count($params) !== 2) {
            throw new HttpBadRequestException($this->getRequest());
        } elseif ($params['name'] == '') {
            throw new HttpBadRequestException($this->getRequest());
        }

        $rom = new Collection($this->romService->getByName($params['name']));

        return $this->respondWithPayload(
            new CollectionPayload($rom,RomPayload::class)
        );
    }
}
