<?php
namespace Lsv\TvmazeApi\Api\Show\Traits;

use Lsv\TvmazeApi\Api\Show\Embed\EmbedEpisodes;

trait EmbedEpisodesTrait
{

    /**
     * Embed episodes in result
     */
    public function embedEpisodes()
    {
        $this->options[EmbedEpisodes::getResolverKey()][] = EmbedEpisodes::getResolverAllowedValue();
    }
}
