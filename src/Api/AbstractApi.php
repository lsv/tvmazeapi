<?php

namespace Lsv\TvmazeApi\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Lsv\TvmazeApi\Api\Show\Embed\Embeds;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractApi implements ApiInterface
{
    /**
     * Name of the API.
     */
    const API_NAME = '';

    /**
     * Version of the API.
     */
    const API_VERSION = '';

    /**
     * Base url.
     */
    const API_BASEURL = '//api.tvmaze.com/';

    /**
     * HTTP Client.
     *
     * @var Client|null
     */
    private $client;

    /**
     * HTTP base url.
     *
     * @var null|string
     */
    private $baseurl;

    /**
     * Url options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * The request.
     *
     * @var RequestInterface
     */
    private $request;

    /**
     * The response.
     *
     * @var ResponseInterface
     */
    private $response;
    /**
     * @var bool
     */
    private $secure = true;

    /**
     * Create API request and response.
     *
     * @param Client|null $client
     * @param string|null $baseurl
     * @param bool $secure
     */
    public function __construct(Client $client = null, $baseurl = null, $secure = true)
    {
        $this->secure = $secure;
        $this->setClient($client);
        $this->setBaseUrl($baseurl);
    }

    /**
     * Set HTTP client.
     *
     * @param Client|null $client
     */
    public function setClient(Client $client = null)
    {
        if ($client === null) {
            $client = new Client();
        }
        $this->client = $client;
    }

    /**
     * Set HTTP base url.
     *
     * @param null $url
     */
    public function setBaseUrl($url = null)
    {
        if ($url === null) {
            $url = sprintf('http%s:%s', $this->secure ? 's' : '', self::API_BASEURL);
        }

        $this->baseurl = rtrim($url, '/');
    }

    /**
     * Configure the allowed options.
     *
     * @param OptionsResolver $options
     *
     * @return void
     */
    abstract protected function configureOptions(OptionsResolver $options);

    /**
     * Generate the url from the options.
     *
     * @param array $options
     *
     * @return string
     */
    abstract protected function getUrl(array $options);

    /**
     * Generate reponse from response interface.
     *
     * @param array             $options
     * @param ResponseInterface $response
     *
     * @return mixed
     */
    abstract protected function generateResponse(array $options, ResponseInterface $response);

    /**
     * Resolve options.
     */
    protected function resolveOptions()
    {
        $resolver = new OptionsResolver();

        $classes = class_uses($this);
        foreach (Embeds::getEmbeds() as $embedClass) {
            if (in_array($embedClass::getTraitClass(), $classes)) {
                $resolver->setDefined($embedClass::getResolverKey());
                $resolver->addAllowedTypes($embedClass::getResolverKey(), 'array');
            }
        }

        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($this->options);
    }

    /**
     * Create request.
     */
    protected function createRequest()
    {
        $url = sprintf('%s/%s', $this->baseurl, $this->getUrl($this->options));
        $this->request = new Request($this->getMethod(), $url, $this->getHeaders());
    }

    /**
     * Do the actual API call.
     *
     * @return mixed
     */
    protected function doCall()
    {
        $this->resolveOptions();
        $this->createRequest();
        try {
            $this->response = $this->client->send($this->request);
        } catch (GuzzleException $exception) {
            $this->response = new Response($exception->getCode(), [], $exception->getMessage());
        }

        return $this->generateResponse($this->options, $this->response);
    }

    /**
     * Validate json.
     *
     * @param ResponseInterface $response
     *
     * @return array
     */
    protected function validateJson(ResponseInterface $response)
    {
        try {
            return \GuzzleHttp\json_decode((string) $response->getBody(), true);
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * HTTP Method.
     *
     * @return string
     */
    protected function getMethod()
    {
        return 'GET';
    }

    /**
     * HTTP client headers.
     *
     * @return array
     */
    protected function getHeaders()
    {
        return [
            'User-Agent' => sprintf('%s/%s', self::API_NAME, self::API_VERSION),
        ];
    }

    /**
     * Get the request, this will not send the request.
     *
     * @return RequestInterface
     */
    public function getRequest()
    {
        if (!$this->request) {
            $this->resolveOptions();
            $this->createRequest();
        }

        return $this->request;
    }

    /**
     * Get the response, this will send the request.
     *
     * @return ResponseInterface
     */
    public function getResponse()
    {
        if (!$this->response) {
            $this->doCall();
        }

        return $this->response;
    }
}
