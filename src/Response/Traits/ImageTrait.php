<?php

namespace Lsv\TvmazeApi\Response\Traits;

trait ImageTrait
{
    /**
     * Medium image.
     *
     * @var string
     */
    public $mediumImage;

    /**
     * Original image.
     *
     * @var string
     */
    public $originalImage;

    /**
     * Set images.
     *
     * @param array|null $image
     */
    protected function setImage($image = null)
    {
        if ($image && is_array($image)) {
            if (isset($image['medium'])) {
                $this->mediumImage = $image['medium'];
            }

            if (isset($image['original'])) {
                $this->originalImage = $image['original'];
            }
        }
    }
}
