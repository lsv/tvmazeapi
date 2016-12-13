<?php
namespace Lsv\TvmazeApi\Api\Show\Embed;

interface EmbedInterface
{

    /**
     * Trait class name
     *
     * @return string
     */
    public static function getTraitClass();

    /**
     * Resolver key
     *
     * @return string
     */
    public static function getResolverKey();

    /**
     * Allowed value for resolver
     *
     * @return string
     */
    public static function getResolverAllowedValue();

    /**
     * Key in response
     *
     * @return string
     */
    public static function getResponseKey();

    /**
     * Is the response an array
     *
     * @return bool
     */
    public static function getResponseIsArray();

    /**
     * Name of the response object
     *
     * @return string
     */
    public static function getResponseObject();

    /**
     * Setter name in the response object
     *
     * @return string
     */
    public static function getResponseSetter();
}
