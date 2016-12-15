<?php
namespace Lsv\TvmazeApiTest\Api\Show;

use Lsv\TvmazeApi\Api\Show\FindById;
use Lsv\TvmazeApi\Response\ShowResponse;
use Lsv\TvmazeApiTest\AbstractApiTest;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

class FindByIdTest extends AbstractApiTest
{

    public function test_correct_url()
    {
        $api = new FindById();
        $api->setId(12345);
        $request = $api->getRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals($this->getUrl('shows/12345'), (string)$request->getUri());
    }

    public function test_result()
    {
        $api = new FindById($this->getClient(__DIR__ . '/SingleSearch/output/response.json'));
        $api->setId(12345);
        $result = $api->call();

        $this->assertInstanceOf(ShowResponse::class, $result);

    }

}
