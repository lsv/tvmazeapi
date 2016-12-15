<?php

namespace Lsv\TvmazeApi\Api\Show;

use Lsv\TvmazeApi\Api\AbstractApi;
use Lsv\TvmazeApi\Api\Show\Traits\EmbedEpisodesTrait;
use Lsv\TvmazeApi\Api\Show\Traits\EmbedNextEpisodeTrait;
use Lsv\TvmazeApi\Response\ShowResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FindById extends AbstractApi
{
    use EmbedEpisodesTrait;
    use EmbedNextEpisodeTrait;

    /**
     * TV Maze show ID.
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->options['id'] = $id;
    }

    /**
     * Configure the allowed options.
     *
     * @param OptionsResolver $options
     *
     * @return void
     */
    protected function configureOptions(OptionsResolver $options)
    {
        $options->setRequired('id');
    }

    /**
     * Generate the url from the options.
     *
     * @param array $options
     *
     * @return string
     */
    protected function getUrl(array $options)
    {
        $id = $options['id'];
        unset($options['id']);
        $query = http_build_query($options);
        return sprintf('shows/%d?%s', $id, $query);
    }

    /**
     * Generate reponse from response interface.
     *
     * @param array             $options
     * @param ResponseInterface $response
     *
     * @return ShowResponse
     */
    protected function generateResponse(array $options, ResponseInterface $response)
    {
        $response = $this->validateJson($response);

        return new ShowResponse($response, 'show');
    }

    /**
     * Do the call.
     *
     * @return ShowResponse
     */
    public function call()
    {
        return $this->doCall();
    }
}
