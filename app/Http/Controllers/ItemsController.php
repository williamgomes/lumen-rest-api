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

    /**
     * @OA\Get(
     *     path="/api/hotelier/{hotelierId}/items/perPage/{perPage}",
     *     tags={"Items"},
     *     summary="Get all items.",
     *     description="Get all Items with pagination for given Hotelier.",
     *     operationId="index",
     *     deprecated=false,
     *     @OA\Parameter(
     *         name="hotelierId",
     *         in="path",
     *         description="ID of a specific Hotelier",
     *         required=true,
     *         @OA\Schema(
     *             default="1",
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="perPage",
     *         in="path",
     *         description="Determine how many items will be shown per page.",
     *         required=false,
     *         @OA\Schema(
     *             default="10",
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     ),
     * )
     */
    public function index(int $hotelierId, int $perPage = self::MIN_ITEMS_PER_PAGE): JsonResponse
    {
        $paginator = Item::where('hotelier_id', $hotelierId)
            ->where('deleted_at', null)
            ->paginate($perPage);
        $resource = $this->getCollectionTransformedResource($paginator, $this->itemTransformer, $this->customSerializer, ['location']);
        return $this->successResponseWithData($resource);
    }

    /**
     * @OA\Get(
     *     path="/api/hotelier/{hotelierId}/items/ratings/{rating}/perPage/{perPage}",
     *     tags={"Items"},
     *     summary="Get all items by rating.",
     *     description="Get all Items with pagination those have the rating given.",
     *     operationId="getByRating",
     *     deprecated=false,
     *     @OA\Parameter(
     *         name="hotelierId",
     *         in="path",
     *         description="ID of a specific Hotelier",
     *         required=true,
     *         @OA\Schema(
     *             default="1",
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="rating",
     *         in="path",
     *         description="Rating of an item. The value should be between 0 and 5.",
     *         required=true,
     *         @OA\Schema(
     *             default="1",
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="perPage",
     *         in="path",
     *         description="Determine how many items will be shown per page.",
     *         required=false,
     *         @OA\Schema(
     *             default="10",
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     ),
     * )
     */
    public function getByRating(int $hotelierId, int $rating, int $perPage = self::MIN_ITEMS_PER_PAGE): JsonResponse
    {
        $paginator = Item::where('hotelier_id', $hotelierId)
            ->where('deleted_at', null)
            ->where('rating', $rating)
            ->paginate($perPage);
        $resource = $this->getCollectionTransformedResource($paginator, $this->itemTransformer, $this->customSerializer, ['location']);
        return $this->successResponseWithData($resource);
    }

    /**
     * @OA\Get(
     *     path="/api/hotelier/{hotelierId}/items/cities/{cityId}/perPage/{perPage}",
     *     tags={"Items"},
     *     summary="Get all items by cityId.",
     *     description="Get all Items with pagination those have the given cityId.",
     *     operationId="getByCity",
     *     deprecated=false,
     *     @OA\Parameter(
     *         name="hotelierId",
     *         in="path",
     *         description="ID of a specific Hotelier",
     *         required=true,
     *         @OA\Schema(
     *             default="1",
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="cityId",
     *         in="path",
     *         description="Id of a City. The value can be obtained from /api/cities endpoint.",
     *         required=true,
     *         @OA\Schema(
     *             default="1",
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="perPage",
     *         in="path",
     *         description="Determine how many items will be shown per page.",
     *         required=false,
     *         @OA\Schema(
     *             default="10",
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     ),
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/hotelier/{hotelierId}/items/badges/{badgeName}/perPage/{perPage}",
     *     tags={"Items"},
     *     summary="Get all items by badgeName.",
     *     description="Get all Items with pagination those have the given badgeName.",
     *     operationId="getByBadge",
     *     deprecated=false,
     *     @OA\Parameter(
     *         name="hotelierId",
     *         in="path",
     *         description="ID of a specific Hotelier",
     *         required=true,
     *         @OA\Schema(
     *             default="1",
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="badgeName",
     *         in="path",
     *         description="Name of a badge. The value should be 'red', 'yellow' or 'green'.",
     *         required=true,
     *         @OA\Schema(
     *             default="red",
     *             type="string",
     *             enum={"red", "yellow", "green"},
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="perPage",
     *         in="path",
     *         description="Determine how many items will be shown per page.",
     *         required=false,
     *         @OA\Schema(
     *             default="10",
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     ),
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/hotelier/{hotelierId}/items/{itemId}",
     *     tags={"Items"},
     *     summary="Get an Item.",
     *     description="Get an Item by the given ID.",
     *     operationId="show",
     *     deprecated=false,
     *     @OA\Parameter(
     *         name="hotelierId",
     *         in="path",
     *         description="ID of a specific Hotelier",
     *         required=true,
     *         @OA\Schema(
     *             default="1",
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="itemId",
     *         in="path",
     *         description="ID of an Item that belongs to the given Hotelier.",
     *         required=true,
     *         @OA\Schema(
     *             default="1",
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     ),
     * )
     */
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
     * @OA\Post(
     *     path="/api/hotelier/{hotelierId}/items",
     *     tags={"Items"},
     *     summary="Create a new Item.",
     *     operationId="Create a new Item.",
     *     @OA\Parameter(
     *         name="hotelierId",
     *         in="path",
     *         description="ID of a specific Hotelier",
     *         required=true,
     *         @OA\Schema(
     *             default="1",
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Input data format.",
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     description="Name of an Item. Should not contain 'Free', 'Offer', 'Book', 'Website' words.",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="category",
     *                     description="Category of an Item.",
     *                     type="string",
     *                     enum={"hotel", "alternative", "hostel", "lodge", "resort", "guest-house"},
     *                 ),
     *                 @OA\Property(
     *                     property="image",
     *                     description="URi of the Image of an Item.",
     *                     type="string",
     *                     default="http://www.example.com",
     *                 ),
     *                 @OA\Property(
     *                     property="reputation",
     *                     description="Reputation of an Item. The value should be between 0 and 1000.",
     *                     type="integer",
     *                     default="100",
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     description="Price of an item per Availability.",
     *                     type="number",
     *                     default="100.00",
     *                 ),
     *                 @OA\Property(
     *                     property="availability",
     *                     description="Number of available accommodation/rooms of an item. The value should be more than 0",
     *                     type="integer",
     *                     default="10",
     *                 ),
     *                 @OA\Property(
     *                     property="address",
     *                     description="Address of an item",
     *                     type="stromg",
     *                 ),
     *                 @OA\Property(
     *                     property="zip_code",
     *                     description="Zip code of an Item. Should be 5 digit number",
     *                     type="integer",
     *                     default="12345",
     *                 ),
     *                 @OA\Property(
     *                     property="rating",
     *                     description="Rating of an Item. The value should be between 0 and 5",
     *                     type="integer",
     *                     default="1",
     *                 ),
     *                 @OA\Property(
     *                     property="city",
     *                     description="ID of the City the Item belongs to.",
     *                     type="integer",
     *                 ),
     *                 @OA\Property(
     *                     property="state",
     *                     description="ID of the State the Item belongs to.",
     *                     type="integer",
     *                 ),
     *                 @OA\Property(
     *                     property="country",
     *                     description="ID of the Country the Item belongs to.",
     *                     type="integer",
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="The process was successful."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Content."
     *     ),
     *     @OA\Response(
     *         response=406,
     *         description="Not acceptable."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="The server encountered an error."
     *     ),
     * )
     */
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
     * @OA\Put(
     *     path="/api/hotelier/{hotelierId}/items/{itemId}",
     *     tags={"Items"},
     *     summary="Update an new Item.",
     *     operationId="Update an new Item.",
     *     @OA\Parameter(
     *         name="hotelierId",
     *         in="path",
     *         description="ID of a specific Hotelier",
     *         required=true,
     *         @OA\Schema(
     *             default="1",
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="itemId",
     *         in="path",
     *         description="ID of a specific Item that should be updated",
     *         required=true,
     *         @OA\Schema(
     *             default="1",
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Input data format.",
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     description="Name of an Item.",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="category",
     *                     description="Category of an Item.",
     *                     type="string",
     *                     enum={"hotel", "alternative", "hostel", "lodge", "resort", "guest-house"},
     *                 ),
     *                 @OA\Property(
     *                     property="image",
     *                     description="URi of the Image of an Item.",
     *                     type="string",
     *                     default="http://www.example.com",
     *                 ),
     *                 @OA\Property(
     *                     property="reputation",
     *                     description="Reputation of an Item. The value should be between 0 and 1000.",
     *                     type="integer",
     *                     default="100",
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     description="Price of an item per Availability.",
     *                     type="number",
     *                     default="100.00",
     *                 ),
     *                 @OA\Property(
     *                     property="availability",
     *                     description="Number of available accommodation/rooms of an item. The value should be more than 0",
     *                     type="integer",
     *                     default="10",
     *                 ),
     *                 @OA\Property(
     *                     property="address",
     *                     description="Address of an item",
     *                     type="stromg",
     *                 ),
     *                 @OA\Property(
     *                     property="zip_code",
     *                     description="Zip code of an Item. Should be 5 digit number",
     *                     type="integer",
     *                     default="12345",
     *                 ),
     *                 @OA\Property(
     *                     property="rating",
     *                     description="Rating of an Item. The value should be between 0 and 5",
     *                     type="integer",
     *                     default="1",
     *                 ),
     *                 @OA\Property(
     *                     property="city",
     *                     description="ID of the City the Item belongs to.",
     *                     type="integer",
     *                 ),
     *                 @OA\Property(
     *                     property="state",
     *                     description="ID of the State the Item belongs to.",
     *                     type="integer",
     *                 ),
     *                 @OA\Property(
     *                     property="country",
     *                     description="ID of the Country the Item belongs to.",
     *                     type="integer",
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="The process was successful."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Content."
     *     ),
     *     @OA\Response(
     *         response=406,
     *         description="Not acceptable."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="The server encountered an error."
     *     ),
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/hotelier/{hotelierId}/items/{itemId}",
     *     tags={"Items"},
     *     summary="Delete an Item",
     *     description="Mark the given Item.",
     *     operationId="delete",
     *     @OA\Parameter(
     *         name="hotelierId",
     *         in="path",
     *         description="ID of a specific Hotelier",
     *         required=true,
     *         @OA\Schema(
     *             default="1",
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="itemId",
     *         in="path",
     *         description="ID of a specific Item that should be updated",
     *         required=true,
     *         @OA\Schema(
     *             default="1",
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The process was successful",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *     )
     * )
     */
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
