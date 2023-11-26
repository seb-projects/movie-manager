<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Behat\MinkExtension\Context\MinkContext;
use PHPUnit\Framework\Assert;

class FeatureContext extends MinkContext implements Context
{
    private string $baseUrl;
    private $response;
    private $browser;

    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
        $this->browser = new HttpBrowser(HttpClient::create());
    }

    /**
     * @When I get movies
     */
    public function iGetMovies()
    {
        $this->browser->request(Request::METHOD_GET, $this->baseUrl . '/movies');
        $this->response = $this->browser->getResponse();
    }

    /**
     * @When I post form filter with:
     */
    public function iGetMoviesWith(TableNode $table)
    {
        $data = [];
        foreach ($table as $row) {
            $data = array_merge($data, $row);
        }
        $crawler = $this->browser->request(Request::METHOD_GET, $this->baseUrl.'/movies');
        $form = $crawler->selectButton('Filtrer')->form();

        foreach ($data as $key => $value) {
            $form[\sprintf('movie_filter[%s]', $key)] = $value;
        }

        $this->browser->submit($form);
        $this->response = $this->browser->getResponse();
    }

    /**
     * @Then the response code should be :code
     */
    public function theResponseCodeShouldBe($code)
    {
        Assert::assertEquals($this->response->getStatusCode(), $code);
    }

    /**
     * @Then the response contains at least one movie
     */
    public function theResponseContainsAtLeastOneMovie()
    {
        $body = $this->response->getContent();
        Assert::assertStringContainsString('<div class="movie">', $body);
    }

    /**
     * @Then the response not contains movies
     */
    public function theResponseNotContainsMovies()
    {
        $body = $this->response->getContent();
        Assert::assertStringNotContainsString('<div class="movie">', $body);
    }

    /**
     * @Then I dump the response
     */
    public function iDumpTheResponse()
    {
        dump($this->response->getContent());
    }
}
