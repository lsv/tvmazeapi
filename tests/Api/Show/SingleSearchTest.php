<?php
namespace Lsv\TvmazeApiTest\Api\Show;

use Lsv\TvmazeApi\Api\Show\SingleSearch;
use Lsv\TvmazeApi\Response\EpisodeResponse;
use Lsv\TvmazeApi\Response\ShowResponse;
use Lsv\TvmazeApiTest\AbstractApiTest;

class SingleSearchTest extends AbstractApiTest
{

    public function test_correct_url()
    {
        $api = new SingleSearch($this->getClient());
        $api->setQuery('designated');
        $request = $api->getRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals($this->getUrl('singlesearch/shows?q=designated'), (string)$request->getUri());
    }

    public function test_correct_url_embeds()
    {
        $api = new SingleSearch($this->getClient());
        $api->embedEpisodes();
        $api->setQuery('designated');
        $request = $api->getRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(
            $this->getUrl('singlesearch/shows?embed%5B0%5D=episodes&q=designated'),
            (string)$request->getUri()
        );

        $api = new SingleSearch($this->getClient());
        $api->embedEpisodes();
        $api->embedNextEpisode();
        $api->setQuery('designated');
        $request = $api->getRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(
            $this->getUrl('singlesearch/shows?embed%5B0%5D=episodes&embed%5B1%5D=nextepisode&q=designated'),
            (string)$request->getUri()
        );
    }

    public function test_response()
    {
        $api = new SingleSearch($this->getClient(__DIR__ . '/SingleSearch/output/response.json'));
        $api->setQuery('designated');
        $result = $api->call();
        $this->assertInstanceOf(ShowResponse::class, $result);
    }

    public function test_response_embed_episodes()
    {
        $api = new SingleSearch($this->getClient(__DIR__ . '/SingleSearch/output/embed_episodes.json'));
        $api->embedEpisodes();
        $api->setQuery('designated');
        $result = $api->call();
        $this->assertInstanceOf(ShowResponse::class, $result);
        $this->assertCount(10, $result->episodes);
        $this->assertNull($result->nextepisode);

        $epi = $result->episodes[0];
        $this->assertEquals(848212, $epi->id);
        $this->assertEquals('http://www.tvmaze.com/episodes/848212/designated-survivor-1x01-pilot', $epi->url);
        $this->assertEquals('Pilot', $epi->name);
        $this->assertEquals(1, $epi->season);
        $this->assertEquals(1, $epi->number);
        $this->assertEquals('21-09-2016', $epi->airdate->format('d-m-Y'));
        $this->assertEquals('22:00', $epi->airtime);
        $this->assertEquals('60', $epi->runtime);
        $this->assertEquals('http://tvmazecdn.com/uploads/images/medium_landscape/76/190262.jpg', $epi->mediumImage);
        $this->assertEquals('http://tvmazecdn.com/uploads/images/original_untouched/76/190262.jpg', $epi->originalImage);
        $this->assertStringStartsWith('<p>Tom Kirkman, a lower-level cabinet member, is suddenly', $epi->summary);
    }

    public function test_response_embed_nextepisode()
    {
        $api = new SingleSearch($this->getClient(__DIR__ . '/SingleSearch/output/embed_nextepisode.json'));
        $api->embedNextEpisode();
        $api->setQuery('designated');
        $result = $api->call();
        $this->assertInstanceOf(ShowResponse::class, $result);
        $this->assertInstanceOf(EpisodeResponse::class, $result->nextepisode);
        $this->assertNull($result->episodes);

        $epi = $result->nextepisode;
        $this->assertEquals(995806, $epi->id);
        $this->assertEquals('http://www.tvmaze.com/episodes/995806/designated-survivor-1x10-the-oath', $epi->url);
        $this->assertEquals('The Oath', $epi->name);
        $this->assertEquals(1, $epi->season);
        $this->assertEquals(10, $epi->number);
        $this->assertEquals('14-12-2016', $epi->airdate->format('d-m-Y'));
        $this->assertEquals('22:00', $epi->airtime);
        $this->assertEquals('60', $epi->runtime);
        $this->assertNull($epi->mediumImage);
        $this->assertNull($epi->originalImage);
        $this->assertStringStartsWith('<p>President Kirkman fears there could be a traitor', $epi->summary);

    }

    public function test_response_embed_episodes_nextepisode()
    {
        $api = new SingleSearch($this->getClient(__DIR__ . '/SingleSearch/output/embed_episodes_nextepisode.json'));
        $api->embedNextEpisode();
        $api->embedEpisodes();
        $api->setQuery('designated');
        $result = $api->call();
        $this->assertInstanceOf(ShowResponse::class, $result);
        $this->assertInstanceOf(EpisodeResponse::class, $result->nextepisode);
        $this->assertCount(10, $result->episodes);
    }

}

