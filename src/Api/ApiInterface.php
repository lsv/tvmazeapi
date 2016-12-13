<?php

namespace Lsv\TvmazeApi\Api;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface ApiInterface
{
    /**
     * Get the request, this will not send the request.
     *
     * @return RequestInterface
     */
    public function getRequest();

    /**
     * Get the response, this will send the request.
     *
     * @return ResponseInterface
     */
    public function getResponse();

    /**
     * Do the call.
     *
     * @return mixed
     */
    public function call();
}
