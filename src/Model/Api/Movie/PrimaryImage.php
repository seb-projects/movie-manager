<?php

namespace App\Model\Api\Movie;

class PrimaryImage
{
    private ?string $url = null;
    private ?Caption $caption = null;

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): PrimaryImage
    {
        $this->url = $url;

        return $this;
    }

    public function getCaption(): ?Caption
    {
        return $this->caption;
    }

    public function setCaption(?Caption $caption): PrimaryImage
    {
        $this->caption = $caption;

        return $this;
    }
}
