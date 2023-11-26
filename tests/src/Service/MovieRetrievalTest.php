<?php

namespace App\Tests\src\Service;

use App\Client\MoviesDatabaseClient;
use App\Model\Api\Movie\Caption;
use App\Model\Api\Movie\MovieApi;
use App\Model\Api\Movie\PrimaryImage;
use App\Model\Api\Movie\ReleaseYear;
use App\Model\Api\Movie\Result;
use App\Model\Api\Movie\TitleText;
use App\Service\MovieRetrieval;
use PHPUnit\Framework\TestCase;

class MovieRetrievalTest extends TestCase
{
    public function testFindBy(): void
    {
        $moviesDatabaseClient = $this->createMock(MoviesDatabaseClient::class);
        $moviesDatabaseClient
            ->expects($this->once())
            ->method('getTitles')
            ->willReturn('{"page":"1","next":"/titles?titleType=movie&list=top_boxoffice_200&page=2","entries":10,"results":[{"_id":"61e581048a5a6a599f4150cf","id":"tt0076759","primaryImage":{"id":"rm3263717120","width":1820,"height":2827,"url":"https://m.media-amazon.com/images/M/MV5BNzVlY2MwMjktM2E4OS00Y2Y3LWE3ZjctYzhkZGM3YzA1ZWM2XkEyXkFqcGdeQXVyNzkwMjQ5NzM@._V1_.jpg","caption":{"plainText":"Alec Guinness, Harrison Ford, Anthony Daniels, Carrie Fisher, Mark Hamill, James Earl Jones, Peter Cushing, David Prowse, Kenny Baker, and Peter Mayhew in Star Wars (1977)","__typename":"Markdown"},"__typename":"Image"},"titleType":{"text":"Movie","id":"movie","isSeries":false,"isEpisode":false,"__typename":"TitleType"},"titleText":{"text":"Star Wars: Episode IV - A New Hope","__typename":"TitleText"},"originalTitleText":{"text":"Star Wars","__typename":"TitleText"},"releaseYear":{"year":1977,"endYear":null,"__typename":"YearRange"},"releaseDate":{"day":15,"month":12,"year":1977,"__typename":"ReleaseDate"},"position":110}]}');
        $movieRetrieval = new MovieRetrieval($moviesDatabaseClient);

        $movieRetrievalResult = $movieRetrieval->findBy(['titleType' => 'movie', 'list' => 'top_boxoffice_200'], MoviesDatabaseClient::MODE_GET_TITLES);

        $caption = (new Caption())
            ->setPlainText('Alec Guinness, Harrison Ford, Anthony Daniels, Carrie Fisher, Mark Hamill, James Earl Jones, Peter Cushing, David Prowse, Kenny Baker, and Peter Mayhew in Star Wars (1977)');

        $primaryImage = (new PrimaryImage())
            ->setUrl('https://m.media-amazon.com/images/M/MV5BNzVlY2MwMjktM2E4OS00Y2Y3LWE3ZjctYzhkZGM3YzA1ZWM2XkEyXkFqcGdeQXVyNzkwMjQ5NzM@._V1_.jpg')
            ->setCaption($caption);

        $titleText = (new TitleText())
            ->setText('Star Wars: Episode IV - A New Hope');

        $releaseYear = (new ReleaseYear())
            ->setYear(1977);

        $result = (new Result())
            ->setId('tt0076759')
            ->setPrimaryImage($primaryImage)
            ->setTitleText($titleText)
            ->setReleaseYear($releaseYear);

        $expectedMovieApi = (new MovieApi())
            ->setPage('1')
            ->addResult($result);

        $this->assertEquals($expectedMovieApi, $movieRetrievalResult);
    }
}
