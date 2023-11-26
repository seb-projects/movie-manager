<?php

namespace App\Model\Api\Movie;

class Result
{
    private string $id;
    private PrimaryImage $primaryImage;
    private TitleText $titleText;
    private ReleaseYear $releaseYear;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): Result
    {
        $this->id = $id;

        return $this;
    }

    public function getPrimaryImage(): PrimaryImage
    {
        return $this->primaryImage;
    }

    public function setPrimaryImage(PrimaryImage $primaryImage): Result
    {
        $this->primaryImage = $primaryImage;

        return $this;
    }

    public function getTitleText(): TitleText
    {
        return $this->titleText;
    }

    public function setTitleText(TitleText $titleText): Result
    {
        $this->titleText = $titleText;

        return $this;
    }

    public function getReleaseYear(): ReleaseYear
    {
        return $this->releaseYear;
    }

    public function setReleaseYear(ReleaseYear $releaseYear): Result
    {
        $this->releaseYear = $releaseYear;

        return $this;
    }
}
