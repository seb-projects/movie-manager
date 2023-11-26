<?php

namespace App\Model\Api\Movie;

class TitleText
{
    private string $text;

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): TitleText
    {
        $this->text = $text;

        return $this;
    }
}
