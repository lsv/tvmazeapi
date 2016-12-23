<?php

namespace Lsv\TvmazeApi\Response;

use Lsv\TvmazeApi\Response\Traits\IdTrait;
use Lsv\TvmazeApi\Response\Traits\ImageTrait;
use Lsv\TvmazeApi\Response\Traits\NameTrait;
use Lsv\TvmazeApi\Response\Traits\UrlTrait;

class EpisodeResponse extends AbstractResponse
{
    use IdTrait;
    use UrlTrait;
    use NameTrait;
    use ImageTrait;

    /**
     * Season number.
     *
     * @var int
     */
    public $season;

    /**
     * Episode number.
     *
     * @var int
     */
    public $number;

    /**
     * Episode air date.
     *
     * @var \DateTime
     */
    public $airdate;

    /**
     * Episode air time.
     *
     * @var string
     */
    public $airtime;

    /**
     * Episode airdate with timezone
     *
     * @var \DateTime
     */
    public $airstamp;

    /**
     * Episode runtime.
     *
     * @var int
     */
    public $runtime;

    /**
     * Episode summary.
     *
     * @var string
     */
    public $summary;

    /**
     * Set air date.
     *
     * @param string $airdate
     */
    protected function setAirdate($airdate)
    {
        $this->airdate = $this->textToDate($airdate);
    }

    /**
     * Set air stamp
     *
     * @param string $airstamp
     */
    protected function setAirstamp($airstamp)
    {
        $this->airstamp = new \DateTime($airstamp);
    }
}
