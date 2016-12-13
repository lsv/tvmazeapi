<?php
namespace Lsv\TvmazeApi\Api\Show;

use Lsv\TvmazeApi\Api\Show\Traits\EmbedEpisodesTrait;
use Lsv\TvmazeApi\Api\Show\Traits\EmbedNextEpisodeTrait;
use Lsv\TvmazeApi\Response\ShowResponse;
use Psr\Http\Message\ResponseInterface;

class SingleSearch extends Search
{
    use EmbedEpisodesTrait;
    use EmbedNextEpisodeTrait;

    /**
     * Generate the url from the options
     *
     * @param array $options
     * @return string
     */
    protected function getUrl(array $options)
    {
        return sprintf('singlesearch/shows?%s', http_build_query($options));
    }

    /**
     * Generate reponse from response interface
     *
     * @param array $options
     * @param ResponseInterface $response
     * @return ShowResponse
     */
    protected function generateResponse(array $options, ResponseInterface $response)
    {
        $response = $this->validateJson($response);
        return new ShowResponse($response, 'show');
    }

    /**
     * Do the call
     *
     * @return ShowResponse
     */
    public function call()
    {
        return $this->doCall();
    }
}
