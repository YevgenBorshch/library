<?php

namespace Tests\Unit\Http\Controllers\Api\Series;


use App\Models\User;
use Tests\TestCase;

class SeriesGetControllerTest extends TestCase
{
    /**
     * @var string
     */
    protected string $token;

    protected function setUp():void
    {
        parent::setUp();
        $this->token = User::factory()->create()->createToken('list')->accessToken;
    }

    public function testSeriesGetValid(): void
    {
        $response = $this->getJson(route("series.get", [
            'series' => 1,
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('id', $content['series']);
        $this->assertArrayHasKey('title', $content['series']);
        $this->assertCount(1, $content);
        $this->assertCount(4, $content['series']);
    }

    public function testSeriesGetWithIdInvalid(): void
    {
        $response = $this->getJson(route("series.get", [
            'series' => 100500,
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(404);
    }
}
