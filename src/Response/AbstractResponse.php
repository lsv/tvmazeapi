<?php
namespace Lsv\TvmazeApi\Response;

use Lsv\TvmazeApi\Api\Show\Embed\Embeds;

abstract class AbstractResponse
{

    /**
     * Create response object
     *
     * @param array|null $response
     * @param string|null $key
     */
    public function __construct(array $response = null, $key = null)
    {
        $this->createResponse($response, $key);
    }

    /**
     * Generate response
     *
     * @param array|null $response
     * @param string|null $key
     * @return void
     */
    protected function createResponse(array $response = null, $key = null)
    {
        if ($key !== null && isset($response[$key])) {
            $response = $response[$key];
        }

        if ($parsed = $this->parseEmbeds($response)) {
            $response = array_merge($response, $parsed);
        }

        foreach ($response as $key => $value) {
            $setter = sprintf('set%s', ucfirst($key));
            if (method_exists($this, $setter)) {
                $this->{$setter}($value);
                continue;
            }

            if (property_exists($this, $key)) {
                $this->{$key} = $value;
                continue;
            }
        }
    }

    /**
     * Parse embeds
     *
     * @param array $response
     * @return array
     */
    protected function parseEmbeds(array $response)
    {
        $output = [];
        foreach (Embeds::getEmbeds() as $embedClass) {
            if (isset($response['_embedded'][$embedClass::getResponseKey()])) {
                $data = $response['_embedded'][$embedClass::getResponseKey()];
                $class = $embedClass::getResponseObject();
                if ($embedClass::getResponseIsArray()) {
                    $this->parseEmbedsArray(
                        $output,
                        $data,
                        $embedClass::getResponseKey(),
                        $embedClass::getResponseSetter(),
                        $class
                    );
                } else {
                    $this->parseEmbedsSingle(
                        $output,
                        $data,
                        $embedClass::getResponseKey(),
                        $embedClass::getResponseSetter(),
                        $class
                    );
                }
            }
        }

        return $output;
    }

    /**
     * Parse embeds if array
     *
     * @param array $output
     * @param array $data
     * @param string $responseKey
     * @param string $setter
     * @param string $className
     */
    private function parseEmbedsArray(array &$output, array $data, $responseKey, $setter, $className)
    {
        foreach ($data as $resp) {
            $output[$setter][] = new $className($resp, $responseKey);
        }
    }

    /**
     * Parse embeds if not array
     *
     * @param array $output
     * @param array $data
     * @param string $responseKey
     * @param string $setter
     * @param string $className
     */
    private function parseEmbedsSingle(array &$output, array $data, $responseKey, $setter, $className)
    {
        $output[$setter] = new $className(
            $data,
            $responseKey
        );
    }

    /**
     * Text to date
     *
     * @param string $date
     * @return \DateTime
     */
    protected function textToDate($date)
    {
        return new \DateTime($date);
    }
}
