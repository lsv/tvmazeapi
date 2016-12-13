<?php
namespace Lsv\TvmazeApiTest\Api\Show;

use Lsv\TvmazeApi\Api\Show\Search;
use Lsv\TvmazeApiTest\AbstractApiTest;

class SearchTest extends AbstractApiTest
{

    public function test_correct_url()
    {
        $api = new Search();
        $api->setQuery('designated');
        $request = $api->getRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals($this->getUrl('search/shows?q=designated'), (string)$request->getUri());
    }

    public function test_count_response()
    {
        $api = new Search($this->getClient(__DIR__.'/Search/output/search.json'));
        $api->setQuery('designated');
        $result = $api->call();
        $this->assertCount(2, $result);
    }

    public function test_response()
    {
        $api = new Search($this->getClient(__DIR__.'/Search/output/search.json'));
        $api->setQuery('designated');
        $result = $api->call();
        $res = $result[0];

        $this->assertEquals(8167, $res->id);
        $this->assertEquals('http://www.tvmaze.com/shows/8167/designated-survivor', $res->url);
        $this->assertEquals('Designated Survivor', $res->name);
        $this->assertEquals('http://tvmazecdn.com/uploads/images/medium_portrait/65/164877.jpg', $res->mediumImage);
        $this->assertEquals('http://tvmazecdn.com/uploads/images/original_untouched/65/164877.jpg', $res->originalImage);
        $this->assertEquals('Scripted', $res->type);
        $this->assertEquals('English', $res->language);
        $this->assertCount(2, $res->genres);
        $this->assertEquals('Drama', $res->genres[0]);
        $this->assertEquals('Thriller', $res->genres[1]);
        $this->assertEquals('Running', $res->status);
        $this->assertEquals(60, $res->runtime);
        $this->assertEquals('21-09-2016', $res->premiered->format('d-m-Y'));
        $this->assertCount(1, $res->scheduleDays);
        $this->assertEquals('Wednesday', $res->scheduleDays[0]);
        $this->assertEquals('22:00', $res->scheduleTime);
        $this->assertEquals(8.2, $res->rating);
        $this->assertEquals('ABC (US)', $res->network);
        $this->assertStringStartsWith('<p>Kiefer Sutherland stars as Tom Kirkman', $res->summary);
    }

    public function test_noresults()
    {
        $api = new Search($this->getClient(__DIR__.'/Search/output/noresults.json'));
        $api->setQuery('designated');
        $result = $api->call();
        $this->assertCount(0, $result);
    }

    public function test_invalid_response()
    {
        $api = new Search($this->getClient(__DIR__.'/Search/output/invalid.txt'));
        $api->setQuery('designated');
        $result = $api->call();
        $this->assertCount(0, $result);
    }

    public function test_500_response()
    {
        $api = new Search($this->getClient(__DIR__.'/Search/output/invalid.txt', 500));
        $api->setQuery('designated');
        $result = $api->call();
        $this->assertCount(0, $result);

        $response = $api->getResponse();
        $this->assertEquals(500, $response->getStatusCode());
    }

    public function test_get_response_before_result()
    {
        $api = new Search($this->getClient(__DIR__.'/Search/output/search.json'));
        $api->setQuery('designated');
        $response = $api->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }

}
