<?php
namespace Lsv\TvmazeApiTest\Api\Show;

use Lsv\TvmazeApi\Api\Show\Lookup;
use Lsv\TvmazeApiTest\AbstractApiTest;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;

class LookupTest extends AbstractApiTest
{

    public function test_correct_url_tvrage()
    {
        $api = new Lookup();
        $api->setTvrageId(12345);
        $request = $api->getRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals($this->getUrl('lookup/shows?tvrage=12345'), (string)$request->getUri());
    }

    public function test_correct_url_thetvdb()
    {
        $api = new Lookup();
        $api->setThetvbbId(12345);
        $request = $api->getRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals($this->getUrl('lookup/shows?thetvdb=12345'), (string)$request->getUri());
    }

    public function test_correct_url_imdb()
    {
        $api = new Lookup();
        $api->setImdbId(12345);
        $request = $api->getRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals($this->getUrl('lookup/shows?imdb=12345'), (string)$request->getUri());
    }

    public function test_unknown_site()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Site can only be one of the following: tvrage, thetvdb, imdb');
        $api = new Lookup();
        $api->setSite('unknown', 123);
        $api->getRequest();
    }

    public function test_notset()
    {
        $this->expectException(MissingOptionsException::class);
        $this->expectExceptionMessage('The required options "id", "site" are missing.');
        $api = new Lookup();
        $api->getRequest();
    }

}
