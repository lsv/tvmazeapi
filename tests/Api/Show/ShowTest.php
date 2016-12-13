<?php
namespace Lsv\TvmazeApiTest\Api\Show;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Lsv\TvmazeApi\Api\Show;
use Lsv\TvmazeApi\Response\ShowResponse;
use Lsv\TvmazeApiTest\AbstractApiTest;

class ShowTest extends AbstractApiTest
{

    private function getResponses()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . '/SingleSearch/output/response.json')),
            new Response(200, [], file_get_contents(__DIR__ . '/SingleSearch/output/response.json')),
            new Response(200, [], file_get_contents(__DIR__ . '/SingleSearch/output/response.json')),
            new Response(200, [], file_get_contents(__DIR__ . '/SingleSearch/output/response.json')),
            new Response(200, [], file_get_contents(__DIR__ . '/Search/output/search.json')),
            new Response(200, [], file_get_contents(__DIR__ . '/SingleSearch/output/response.json')),
        ]);
        $handler = HandlerStack::create($mock);
        return new Client(['handler' => $handler]);
    }

    private function getInstance()
    {
        return Show::getInstance($this->getResponses());
    }

    public function test_findbyid()
    {
        $result = $this->getInstance()->findById(1234, true, true);
        $this->assertInstanceOf(ShowResponse::class, $result);
    }

    public function test_lookup_tvrage()
    {
        $result = $this->getInstance()->lookupFromTvrage(123);
        $this->assertInstanceOf(ShowResponse::class, $result);
    }

    public function test_lookup_thetvdb()
    {
        $result = $this->getInstance()->lookupFromThetvdb(123);
        $this->assertInstanceOf(ShowResponse::class, $result);
    }

    public function test_lookup_imdb()
    {
        $result = $this->getInstance()->lookupFromImdb(123);
        $this->assertInstanceOf(ShowResponse::class, $result);
    }

    public function test_search()
    {
        $result = $this->getInstance()->search('query');
        $this->assertCount(2, $result);
    }

    public function test_singlesearch()
    {
        $result = $this->getInstance()->singleSearch('query', true, true);
        $this->assertInstanceOf(ShowResponse::class, $result);
    }

}
