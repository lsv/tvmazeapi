<?php
namespace Lsv\TvmazeApiTest;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Lsv\TvmazeApi\Api\AbstractApi;

abstract class AbstractApiTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @param string $url
     * @param bool $secure
     * @return string
     */
    protected function getUrl($url, $secure = true)
    {
        return sprintf('http%s:%s%s', $secure ? 's' : '', AbstractApi::API_BASEURL, $url);
    }

    /**
     * @param string $outputFile
     * @param int $code
     * @return Client
     */
    protected function getClient($outputFile = null, $code = 200)
    {
        if ($outputFile) {
            $mock = new MockHandler([
                new Response($code, [], file_get_contents($outputFile)),
            ]);
        } else {
            $mock = new MockHandler();
        }

        $handler = HandlerStack::create($mock);
        return new Client(['handler' => $handler]);
    }

}
