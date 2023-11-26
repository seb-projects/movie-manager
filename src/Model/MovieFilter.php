<?php

namespace App\Model;

final class MovieFilter
{
    public const YEAR_DEFAULT_VALUE = null;
    public const TYPE_DEFAULT_VALUE = 'movie';
    public const LIST_DEFAULT_VALUE = 'top_boxoffice_200';
    public const GENRE_DEFAULT_VALUE = null;
    public const PAGE_DEFAULT_VALUE = 1;
    private ?int $year = null;
    private ?string $titleType = null;
    private ?string $list = null;
    private ?string $genre = null;
    private ?string $title = null;
    private ?string $keyword = null;
    private ?int $page = null;

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getTitleType(): ?string
    {
        return $this->titleType;
    }

    public function setTitleType(?string $titleType): self
    {
        $this->titleType = $titleType;

        return $this;
    }

    public function getList(): ?string
    {
        return $this->list;
    }

    public function setList(?string $list): self
    {
        $this->list = $list;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getKeyword(): ?string
    {
        return $this->keyword;
    }

    public function setKeyword(?string $keyword): self
    {
        $this->keyword = $keyword;

        return $this;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function setPage(?int $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function toArray(): array
    {
        return $this->removeNullValues();
    }

    private function removeNullValues(): array
    {
        return \array_filter(get_object_vars($this), function ($value) {
            return null !== $value;
        });
    }
}
