<?php

namespace App\Model\Api\Movie;

class Caption
{
    private ?string $plainText = null;

    public function getPlainText(): ?string
    {
        return $this->plainText;
    }

    public function setPlainText(?string $plainText): Caption
    {
        $this->plainText = $plainText;

        return $this;
    }
}
