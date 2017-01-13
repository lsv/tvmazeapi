<?php

namespace Lsv\TvmazeApi\Api;

use GuzzleHttp\ClientInterface;
use Lsv\TvmazeApi\Api\Show as Api;
use Lsv\TvmazeApi\Response\ShowResponse;

class Show
{
    /**
     * Instance.
     *
     * @var
     */
    private static $instance;

    /**
     * HTTP client.
     *
     * @var ClientInterface|null
     */
    private $client;

    /**
     * HTTP baseurl.
     *
     * @var string|null
     */
    private $baseUrl;

    /**
     * @var bool
     */
    private $secure;

    private function __construct(ClientInterface $client = null, $baseUrl = null, $secure = true)
    {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
        $this->secure = $secure;
    }

    /**
     * @codeCoverageIgnore
     */
    private function __wakeup()
    {
    }

    /**
     * @codeCoverageIgnore
     */
    private function __clone()
    {
    }

    /**
     * Get instance.
     *
     * @param ClientInterface|null $client
     * @param string|null $baseUrl
     * @param bool $secure
     * @return Show
     */
    public static function getInstance(ClientInterface $client = null, $baseUrl = null, $secure = true)
    {
        if (self::$instance === null) {
            self::$instance = new self($client, $baseUrl, $secure);
        }

        return self::$instance;
    }

    /**
     * Find show by ID.
     *
     * @param int  $id
     * @param bool $embedEpisodes
     * @param bool $embedNextepisode
     *
     * @return ShowResponse
     */
    public function findById($id, $embedEpisodes = false, $embedNextepisode = false)
    {
        $api = new Api\FindById($this->client, $this->baseUrl);
        $api->setId($id);
        if ($embedEpisodes) {
            $api->embedEpisodes();
        }

        if ($embedNextepisode) {
            $api->embedNextEpisode();
        }

        return $api->call();
    }

    /**
     * Lookup show from tvrage.
     *
     * @param string $id
     *
     * @return ShowResponse
     */
    public function lookupFromTvrage($id)
    {
        return $this->lookup('tvrage', $id);
    }

    /**
     * Lookup show thetvdb.
     *
     * @param string $id
     *
     * @return ShowResponse
     */
    public function lookupFromThetvdb($id)
    {
        return $this->lookup('thetvdb', $id);
    }

    /**
     * Lookup show from imdb.
     *
     * @param string $id
     *
     * @return ShowResponse
     */
    public function lookupFromImdb($id)
    {
        return $this->lookup('imdb', $id);
    }

    /**
     * Search for shows.
     *
     * @param string $query
     *
     * @return ShowResponse[]
     */
    public function search($query)
    {
        $api = new Api\Search($this->client, $this->baseUrl);
        $api->setQuery($query);

        return $api->call();
    }

    /**
     * Search for a single show.
     *
     * @param string $query
     * @param bool   $embedEpisodes
     * @param bool   $embedNextepisode
     *
     * @return ShowResponse
     */
    public function singleSearch($query, $embedEpisodes = false, $embedNextepisode = false)
    {
        $api = new Api\SingleSearch($this->client, $this->baseUrl);
        $api->setQuery($query);
        if ($embedEpisodes) {
            $api->embedEpisodes();
        }

        if ($embedNextepisode) {
            $api->embedNextEpisode();
        }

        return $api->call();
    }

    /**
     * Lookup show from other sources.
     *
     * @param string $site
     * @param string $id
     *
     * @return ShowResponse
     */
    private function lookup($site, $id)
    {
        $api = new Api\Lookup($this->client, $this->baseUrl);
        $api->setSite($site, $id);

        return $api->call();
    }
}
