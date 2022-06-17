<?php

namespace App\Http\Api\v1\Consult;

use App\Http\Controller;
use App\Payload\CollectionPayload;
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

        if (count($params) !== 2) {
            throw new HttpBadRequestException($this->getRequest());
        } elseif ($params['name'] == '') {
            throw new HttpBadRequestException($this->getRequest());
        }

        // Database consult
        $platform = $this->platformService->getByName($params['name']);
        exit;

        $response = new Collection();
        $response->add($platform);

        return $this->respondWithPayload(
            new CollectionPayload($response,PlatformPayload::class)
        );
    }
}
