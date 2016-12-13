<?php

namespace Lsv\TvmazeApi\Api\Show;

use Lsv\TvmazeApi\Api\AbstractApi;
use Lsv\TvmazeApi\Response\ShowResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Lookup extends AbstractApi
{
    /**
     * Allowed site lookups.
     *
     * @var array
     */
    private static $allowedSites = ['tvrage', 'thetvdb', 'imdb'];

    /**
     * Lookup show from tvrage id.
     *
     * @param string $id
     *
     * @return $this
     */
    public function setTvrageId($id)
    {
        return $this->setSite('tvrage', $id);
    }

    /**
     * Lookup show from thetvdb id.
     *
     * @param string $id
     *
     * @return $this
     */
    public function setThetvbbId($id)
    {
        return $this->setSite('thetvdb', $id);
    }

    /**
     * Lookup show from imdb id.
     *
     * @param string $id
     *
     * @return $this
     */
    public function setImdbId($id)
    {
        return $this->setSite('imdb', $id);
    }

    /**
     * Lookup show from other sources.
     *
     * @param string $site
     * @param string $id
     *
     * @return $this
     */
    public function setSite($site, $id)
    {
        if (!in_array($site, self::$allowedSites)) {
            throw new \InvalidArgumentException(
                'Site can only be one of the following: '.implode(', ', self::$allowedSites)
            );
        }

        $this->options['id'] = $id;
        $this->options['site'] = $site;

        return $this;
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
        $options->setRequired(['site', 'id']);
        $options->addAllowedValues('site', ['tvrage', 'thetvdb', 'imdb']);
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
        $url[$options['site']] = $options['id'];

        return sprintf('lookup/shows?%s', http_build_query($url));
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
