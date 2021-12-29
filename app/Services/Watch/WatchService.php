<?php

namespace App\Services\Watch;

use App\Exceptions\ApiArgumentException;
use App\Models\WatchAuthor;
use App\Repositories\Eloquent\WatchAuthorRepository;
use App\Repositories\Eloquent\WatchSeriesRepository;
use App\Repositories\Interfaces\WatchAuthorRepositoryInterface;
use App\Repositories\Interfaces\WatchSeriesRepositoryInterface;
use App\Services\Http\HttpClient;
use App\Services\Http\HttpClientInterface;
use DOMDocument;
use DOMXPath;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\DomCrawler\Crawler;

class WatchService implements WatchServiceInterface
{
    /**
     * @var WatchAuthorRepositoryInterface
     */
    protected WatchAuthorRepositoryInterface $authorRepository;

    /**
     * @var WatchSeriesRepositoryInterface
     */
    protected WatchSeriesRepositoryInterface $seriesRepository;

    /**
     * @var HttpClientInterface
     */
    protected HttpClientInterface $httpClient;

    public function __construct()
    {
        $this->authorRepository = new WatchAuthorRepository();
        $this->seriesRepository = new WatchSeriesRepository();
        $this->httpClient = new HttpClient();
    }

    /**
     * @throws GuzzleException
     * @throws ApiArgumentException
     */
    public function parseAuthorPage(string $url)
    {
        // Guzzle
        $response = $this->httpClient->get($url);

        // XML errors
        libxml_use_internal_errors(true);

        // DOM
        $doc = new DOMDocument();
        $doc->loadHTML($response);

        // DOM XPath
        $xpath = new DOMXPath($doc);
        $info = $xpath->evaluate('//div[@class="contents"]//h2');
        foreach ($info as $item) {
            $fullName = explode(' ', $item->textContent);
            $this->authorRepository->store([
                'firstname' => $fullName[0],
                'lastname' => $fullName[1],
                'url' => $url,
                'active' => true,
            ]);
        }
    }

    /**
     * @param WatchAuthor $author
     * @return mixed
     * @throws GuzzleException
     */
    public function run(WatchAuthor $author)
    {
        // Guzzle
        $response = $this->httpClient->get($author->url);

        // XML errors
        libxml_use_internal_errors(true);

        // DOM
        $crawler = new Crawler($response);

    }
}
