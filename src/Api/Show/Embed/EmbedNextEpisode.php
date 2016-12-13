<?php

namespace Lsv\TvmazeApi\Api\Show\Embed;

use Lsv\TvmazeApi\Api\Show\Traits\EmbedNextEpisodeTrait;
use Lsv\TvmazeApi\Response\EpisodeResponse;

class EmbedNextEpisode implements EmbedInterface
{
    /**
     * Trait class name.
     *
     * @return string
     */
    public static function getTraitClass()
    {
        return EmbedNextEpisodeTrait::class;
    }

    /**
     * Resolver key.
     *
     * @return string
     */
    public static function getResolverKey()
    {
        return 'embed';
    }

    /**
     * Allowed value for resolver.
     *
     * @return string
     */
    public static function getResolverAllowedValue()
    {
        return 'nextepisode';
    }

    /**
     * Key in response.
     *
     * @return string
     */
    public static function getResponseKey()
    {
        return 'nextepisode';
    }

    /**
     * Is the response an array.
     *
     * @return bool
     */
    public static function getResponseIsArray()
    {
        return false;
    }

    /**
     * Name of the response object.
     *
     * @return string
     */
    public static function getResponseObject()
    {
        return EpisodeResponse::class;
    }

    /**
     * Setter name in the response object.
     *
     * @return string
     */
    public static function getResponseSetter()
    {
        return 'nextepisode';
    }
}
