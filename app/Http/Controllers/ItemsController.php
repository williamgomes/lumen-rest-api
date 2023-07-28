<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateItemRequestValidator;
use App\Http\Requests\UpdateItemRequestValidator;
use App\Models\Item;
use App\Services\ItemService;
use App\Transformers\ItemTransformer;
use App\Transformers\Serializer\TrivagoCustomSerializer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ItemsController extends TrivagoController
{
    public function __construct(
        private readonly ItemService $itemService,
        private readonly TrivagoCustomSerializer $customSerializer,
        private readonly ItemTransformer $itemTransformer
    )
    {
    }

    public function index(int $hotelierId, int $perPage = self::MIN_ITEMS_PER_PAGE): JsonResponse
    {
        $paginator = Item::where('hotelier_id', $hotelierId)
            ->where('deleted_at', null)
            ->paginate($perPage);
        $resource = $this->getCollectionTransformedResource($paginator, $this->itemTransformer, $this->customSerializer, ['location']);
        return $this->successResponseWithData($resource);
    }

    public function getByRating(int $hotelierId, int $rating, int $perPage = self::MIN_ITEMS_PER_PAGE): JsonResponse
    {
        $paginator = Item::where('hotelier_id', $hotelierId)
            ->where('deleted_at', null)
            ->where('rating', $rating)
            ->paginate($perPage);
        $resource = $this->getCollectionTransformedResource($paginator, $this->itemTransformer, $this->customSerializer, ['location']);
        return $this->successResponseWithData($resource);
    }

    public function getByCity(int $hotelierId, int $cityId, int $perPage = self::MIN_ITEMS_PER_PAGE): JsonResponse
    {
        $paginator = Item::where('hotelier_id', $hotelierId)
            ->join('locations', 'locations.item_id', '=', 'items.id')
            ->where('items.deleted_at', null)
            ->where('locations.city_id', $cityId)
            ->paginate($perPage);
        $resource = $this->getCollectionTransformedResource($paginator, $this->itemTransformer, $this->customSerializer, ['location']);
        return $this->successResponseWithData($resource);
    }

    public function getByBadge(int $hotelierId, string $badgeName, int $perPage = self::MIN_ITEMS_PER_PAGE): JsonResponse
    {
        $paginator = Item::where('hotelier_id', $hotelierId)
            ->join('badges', 'items.badge_id', '=', 'badges.id')
            ->where('items.deleted_at', null)
            ->where('badges.name', $badgeName)
            ->paginate($perPage);
        $resource = $this->getCollectionTransformedResource($paginator, $this->itemTransformer, $this->customSerializer, ['location']);
        return $this->successResponseWithData($resource);
    }

    public function show(int $hotelierId, int $itemId): JsonResponse
    {
        $item = $this->itemService->getActiveItemByHotelierIdAndOptionalItemId($hotelierId, $itemId);

        if(!$item) {
            return $this->NotFoundResponse();
        }

        $resource = $this->getSingleTransformedResource($item, $this->itemTransformer, $this->customSerializer, ['location']);
        return $this->successResponseWithData($resource);
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request, int $hotelierId, CreateItemRequestValidator $validator): JsonResponse
    {
        $validator->validateRequest($request);

        try {
            $itemId = $this->itemService->createItem($request);
        } catch (\Exception $exception) {
            return $this->serversideErrorResponse($exception->getMessage());
        }

        $newResourceUri = route('items.show.one', ['hotelierId' => $hotelierId, 'itemId' => $itemId]);
        return $this->createSuccessResponse($newResourceUri);
    }

    /**
     * @throws ValidationException
     */
    public function update(Request $request, int $hotelierId, int $itemId, UpdateItemRequestValidator $validator): JsonResponse
    {
        $item = $this->itemService->getActiveItemByHotelierIdAndOptionalItemId($hotelierId, $itemId);
        if(!$item) {
            return $this->NotFoundResponse();
        }

        $validator->validateRequest($request);

        try {
            $this->itemService->updateItem($request);
        } catch (\Exception $exception) {
            return $this->serversideErrorResponse($exception->getMessage());
        }

        return $this->successResponse("The item was updated successfully.");
    }

    public function delete(int $hotelierId, int $itemId): JsonResponse
    {
        $item = $this->itemService->getActiveItemByHotelierIdAndOptionalItemId($hotelierId, $itemId);

        if (!$item) {
            return $this->NotFoundResponse();
        }

        $this->itemService->markAsDeleted($item);

        return $this->successResponse('Item deleted successfully');
    }
}
