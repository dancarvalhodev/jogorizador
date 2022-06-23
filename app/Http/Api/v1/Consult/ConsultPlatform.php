<?php

namespace App\Http\Api\v1\Consult;

use App\Http\Controller;
use App\Payload\CollectionPayload;
use App\Payload\Consult\PlatformPayload;
use App\Service\Platform\PlatformService;
use DI\Annotation\Inject;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;
use Slim\Exception\HttpBadRequestException;

class ConsultPlatform extends Controller
{
    /**
     * @Inject
     *
     * @var PlatformService
     */
    private PlatformService $platformService;

    /**
     * @return ResponseInterface
     * @throws HttpBadRequestException
     * @throws ReflectionException
     * @throws Exception
     */
    public function getAction(): ResponseInterface
    {
        $params = $this->getRequest()->getQueryParams();

        if (count($params) !== 1) {
            throw new HttpBadRequestException($this->getRequest());
        } elseif ($params['name'] == '') {
            throw new HttpBadRequestException($this->getRequest());
        }

        $platform = new Collection($this->platformService->getByName($params['name']));

        return $this->respondWithPayload(
            new CollectionPayload($platform,PlatformPayload::class)
        );
    }
}
