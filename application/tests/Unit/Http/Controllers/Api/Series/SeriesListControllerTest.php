<?php

namespace Tests\Unit\Http\Controllers\Api\Series;

use App\Models\User;
use Tests\TestCase;

class SeriesListControllerTest extends TestCase
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

    public function testGetSeriesListValid(): void
    {
        $response = $this->getJson(route("series.list", [
            'perPage' => 3,
            'orderBy' => "desc"
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);

        $this->assertFields($content['series']);
    }

    /**
     * @return \int[][]
     */
    public function perPageProviderCase(): array
    {
        return [
            [0],
            [-1]
        ];
    }

    /**
     * @dataProvider perPageProviderCase
     */
    public function testGetSeriesListWithPerPageInvalid(int $perPage): void
    {
        $response = $this->getJson(route('series.list', [
            'perPage' => $perPage,
            'orderBy' => "desc"
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(500);

        $content = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('message', $content);
    }

    public function testGetSeriesListWithoutPerPage(): void
    {
        $response = $this->getJson(route('series.list', [
            'orderBy' => "desc"
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertFields($content['series']);
        $this->assertCount(10, $content['series']['list']);
    }

    public function testGetSeriesListWithoutOrderBy(): void
    {
        $response = $this->getJson(route('series.list', [
            'perPage' => 1,
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertFields($content['series']);
        $this->assertCount(1, $content['series']['list']);
    }

    public function testGetSeriesListWithCurrentPageInvalid(): void
    {
        $response = $this->getJson(route('series.list', [
            'perPage' => 1,
            'currentPage' => 100500
        ]), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertFields($content['series']);
        $this->assertCount(0, $content['series']['list']);
    }

    protected function assertFields(array $series): void
    {
        $this->assertArrayHasKey('currentPage', $series);
        $this->assertArrayHasKey('perPage', $series);
        $this->assertArrayHasKey('total', $series);
        $this->assertArrayHasKey('lastPage', $series);
        $this->assertArrayHasKey('orderBy', $series);
        $this->assertEquals('desc', $series['orderBy']);
        $this->assertArrayHasKey('list', $series);
        $this->assertIsArray($series['list']);
    }
}
