<?php
namespace Lsv\TvmazeApi\Api\Show\Embed;

use Lsv\TvmazeApi\Api\Show\Traits\EmbedEpisodesTrait;
use Lsv\TvmazeApi\Response\EpisodeResponse;

class EmbedEpisodes implements EmbedInterface
{

    /**
     * Trait class name
     *
     * @return string
     */
    public static function getTraitClass()
    {
        return EmbedEpisodesTrait::class;
    }

    /**
     * Resolver key
     *
     * @return string
     */
    public static function getResolverKey()
    {
        return 'embed';
    }

    /**
     * Allowed value for resolver
     *
     * @return string
     */
    public static function getResolverAllowedValue()
    {
        return 'episodes';
    }

    /**
     * Key in response
     *
     * @return string
     */
    public static function getResponseKey()
    {
        return 'episodes';
    }

    /**
     * Is the response an array
     *
     * @return bool
     */
    public static function getResponseIsArray()
    {
        return true;
    }

    /**
     * Name of the response object
     *
     * @return string
     */
    public static function getResponseObject()
    {
        return EpisodeResponse::class;
    }

    /**
     * Setter name in the response object
     *
     * @return string
     */
    public static function getResponseSetter()
    {
        return 'episodes';
    }
}
