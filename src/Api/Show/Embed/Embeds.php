<?php
namespace Lsv\TvmazeApi\Api\Show\Embed;

class Embeds
{

    /**
     * Get embed classes
     *
     * @return EmbedInterface[]
     */
    public static function getEmbeds()
    {
        return [
            EmbedEpisodes::class,
            EmbedNextEpisode::class
        ];
    }
}
