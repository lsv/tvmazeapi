<?php
namespace Lsv\TvmazeApi\Api\Show;

use Lsv\TvmazeApi\Api\AbstractApi;
use Lsv\TvmazeApi\Response\ShowResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Search extends AbstractApi
{

    /**
     * The query to search for
     *
     * @param string $query
     * @return $this
     */
    public function setQuery($query)
    {
        $this->options['q'] = $query;
        return $this;
    }

    /**
     * Configure the allowed options
     *
     * @param OptionsResolver $options
     * @return void
     */
    protected function configureOptions(OptionsResolver $options)
    {
        $options->setRequired(['q']);
        $options->addAllowedTypes('q', ['string']);
    }

    /**
     * Generate the url from the options
     *
     * @param array $options
     * @return string
     */
    protected function getUrl(array $options)
    {
        return sprintf('search/shows?%s', http_build_query($options));
    }

    /**
     * Generate reponse from response interface
     *
     * @param array $options
     * @param ResponseInterface $response
     * @return ShowResponse[]
     */
    protected function generateResponse(array $options, ResponseInterface $response)
    {
        $shows = [];
        $response = $this->validateJson($response);
        foreach ($response as $item) {
            $shows[] = new ShowResponse($item, 'show');
        }
        return $shows;
    }

    /**
     * Do the call
     *
     * @return ShowResponse[]
     */
    public function call()
    {
        return $this->doCall();
    }
}
