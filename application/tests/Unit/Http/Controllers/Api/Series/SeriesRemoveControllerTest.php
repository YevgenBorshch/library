<?php

namespace Tests\Unit\Http\Controllers\Api\Series;


use App\Models\Series;
use App\Models\User;
use Tests\TestCase;

class SeriesRemoveControllerTest extends TestCase
{

    /**
     * @var string
     */
    protected string $token;

    /**
     * @var Series
     */
    protected $series;

    protected function setUp():void
    {
        parent::setUp();
        $this->token = User::factory()->create()->createToken('list')->accessToken;
        $this->series = Series::factory()->create();
    }

    public function testSeriesRemoveValid()
    {
        $response = $this->postJson(route('series.remove'), [
            'id' => $this->series->id,
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(202);

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('result', $content);
        $this->assertTrue($content['result']);
    }

    public function testSeriesRemoveWithoutId(): void
    {
        $response = $this->postJson(route('series.remove'), [], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(500);
        $message = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('message', $message);
    }

    public function testSeriesRemoveWithEmptyId(): void
    {
        $response = $this->postJson(route('series.remove'), [
            'id' => '',
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(500);
        $message = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('message', $message);
    }
}
