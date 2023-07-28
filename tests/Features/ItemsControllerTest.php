<?php

namespace Tests\Features;

use App\Models\Hotelier;
use App\Models\Item;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Tests\TestCase;

class ItemsControllerTest extends TestCase
{
    private array $item;
    private Hotelier $hotelier;

    public function setUp(): void
    {
        parent::setUp();

        $this->hotelier = Hotelier::factory()->create();
        $this->item = [
            'name' => 'Alubazar Premium Hotel',
            'category' => 'hotel',
            'image' => 'https://www.google.com',
            'reputation' => 300,
            'price' => '150.00',
            'availability' => 5,
            'address' => 'Hogamara Lane, Rajabazar',
            'zip_code' => 12345,
            'rating' => 4,
            'city' => 50,
            'state' => 3889,
            'country' => 1,
        ];
    }

    /**
     * @throws GuzzleException
     */
    public function testItemCreatingReturnsSuccessResponse()
    {
        $response = $this->httpClient->post(sprintf('/api/hotelier/%s/items', $this->hotelier->id), ['form_params' => $this->item]);
        $this->assertEquals(201, $response->getStatusCode());

        $headerLocation = $response->getHeaders()["Location"][0];
        $this->assertNotNull($headerLocation);

        $this->assertStringContainsString("The process was successful.", $response->getBody()->getContents());
    }

    public function testItemCreationThrowsValidationErrorWithRestrictedKeyword()
    {
        $this->expectException(ClientException::class);
        $this->item['name'] = 'Free Premium Hotel';
        $response = $this->httpClient->post(sprintf('/api/hotelier/%s/items', $this->hotelier->id), ['form_params' => $this->item]);
        $this->assertStringContainsString("The name contains forbidden word(s).", $response->getBody()->getContents());
    }

    public function testCheckJsonStructureOfGetItemsMethod()
    {
        $item = Item::where('deleted_at', null)->first();
        $this->get(sprintf('/api/hotelier/%s/items/%s', $item->hotelier_id, $item->id));
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            [
                'message',
                'data' => [
                    'name',
                    'rating',
                    'category',
                    'image',
                    'reputation',
                    'reputation_badge',
                    'price',
                    'availability',
                    'location' => [
                        'address',
                        'zip_code',
                        'city',
                        'state',
                        'country',
                    ]
                ]
            ]
        );
    }

    public function testCheckDeleteEndpointMarksItemAsDeleted()
    {
        $item = Item::where('deleted_at', null)->first();
        $this->delete(sprintf('/api/hotelier/%s/items/%s', $item->hotelier_id, $item->id));
        $this->seeStatusCode(200);
        $item->refresh();
        $this->assertNotNull($item->deleted_at);
    }
}
