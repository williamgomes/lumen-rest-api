<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\TransformerAbstract;

class TrivagoController extends BaseController
{
    protected const MIN_ITEMS_PER_PAGE = 10;

    protected function NotFoundResponse(string $message = "Requested resource not found."): JsonResponse
    {
        return response()->json(['message' => $message], 404);
    }

    protected function serversideErrorResponse(string $message = "The server encountered an error."): JsonResponse
    {
        return response()->json(['message' => $message], 500);
    }

    protected function successResponse(string $message = "The process was successful."): JsonResponse
    {
        return response()->json(['message' => $message], 200);
    }

    protected function successResponseWithData(array $data, string $message = "The process was successful."): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ]);
    }

    protected function createSuccessResponse(string $newResourceUri, string $message = "The process was successful."): JsonResponse
    {
        return response()->json(['message' => $message], 201)
            ->header('Location', $newResourceUri);
    }

    protected function notAcceptableResponse(string $message = "The request is not acceptable."): JsonResponse
    {
        return response()->json(['message' => $message], 406);
    }

    protected function getSingleTransformedResource(Model $object, TransformerAbstract $transformer, ArraySerializer $serializer, array|string $parseIncludes = []): array
    {
        $resource = new Item($object, $transformer);
        $manager = $this->getFractalManager($serializer, $parseIncludes);
        return $manager->createData($resource)->toArray();
    }

    protected function getCollectionTransformedResource(LengthAwarePaginator $paginator, TransformerAbstract $transformer, ArraySerializer $serializer, array|string $parseIncludes = []): array
    {
        $collection = $paginator->getCollection();
        $response = new Collection($collection, $transformer);
        $response->setPaginator(new IlluminatePaginatorAdapter($paginator));

        $manager = $this->getFractalManager($serializer, $parseIncludes);

        return $manager->createData($response)->toArray();
    }

    public function getFractalManager(ArraySerializer $serializer, array|string $parseIncludes = []): Manager
    {
        $manager = new Manager();
        $manager->parseIncludes($parseIncludes);
        $manager->setSerializer($serializer);
        return $manager;
    }
}
