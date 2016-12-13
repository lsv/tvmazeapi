<?php
namespace Lsv\TvmazeApi\Api\Show\Traits;

use Lsv\TvmazeApi\Api\Show\Embed\EmbedNextEpisode;

trait EmbedNextEpisodeTrait
{

    /**
     * Embed next episode in result
     */
    public function embedNextEpisode()
    {
        $this->options[EmbedNextEpisode::getResolverKey()][] = EmbedNextEpisode::getResolverAllowedValue();
    }
}
