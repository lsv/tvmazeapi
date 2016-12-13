<?php

namespace Lsv\TvmazeApi\Response;

use Lsv\TvmazeApi\Response\Traits\IdTrait;
use Lsv\TvmazeApi\Response\Traits\ImageTrait;
use Lsv\TvmazeApi\Response\Traits\NameTrait;
use Lsv\TvmazeApi\Response\Traits\UrlTrait;

class ShowResponse extends AbstractResponse
{
    use IdTrait;
    use UrlTrait;
    use NameTrait;
    use ImageTrait;

    /**
     * Type of show.
     *
     * @var string
     */
    public $type;

    /**
     * Language.
     *
     * @var string
     */
    public $language;

    /**
     * Genres.
     *
     * @var array
     */
    public $genres;

    /**
     * Status of show.
     *
     * @var string
     */
    public $status;

    /**
     * Runtime.
     *
     * @var int
     */
    public $runtime;

    /**
     * Premiere date.
     *
     * @var \DateTime
     */
    public $premiered;

    /**
     * Days the show is running.
     *
     * @var array
     */
    public $scheduleDays;

    /**
     * Time the show is running.
     *
     * @var string
     */
    public $scheduleTime;

    /**
     * Rating.
     *
     * @var float
     */
    public $rating;

    /**
     * Network.
     *
     * @var string
     */
    public $network;

    /**
     * Summary of show.
     *
     * @var string
     */
    public $summary;

    /**
     * Episodes.
     *
     * @var EpisodeResponse[]|null
     */
    public $episodes;

    /**
     * Nextepisode.
     *
     * @var EpisodeResponse|null
     */
    public $nextepisode;

    /**
     * Set premiere date.
     *
     * @param string $premiered
     */
    protected function setPremiered($premiered)
    {
        $this->premiered = $this->textToDate($premiered);
    }

    /**
     * Set schedule.
     *
     * @param array $schedule
     */
    protected function setSchedule($schedule)
    {
        if (is_array($schedule)) {
            if (isset($schedule['time'])) {
                $this->scheduleTime = $schedule['time'];
            }

            if (isset($schedule['days'])) {
                $this->scheduleDays = $schedule['days'];
            }
        }
    }

    /**
     * Set rating.
     *
     * @param array $rating
     */
    protected function setRating($rating)
    {
        if (isset($rating['average'])) {
            $this->rating = $rating['average'];
        }
    }

    /**
     * Set network.
     *
     * @param array $network
     */
    protected function setNetwork($network)
    {
        if (isset($network['name'])) {
            $this->network = $network['name'];
        }

        if (isset($network['country']['code'])) {
            $this->network .= ' ('.$network['country']['code'].')';
        }
    }
}
