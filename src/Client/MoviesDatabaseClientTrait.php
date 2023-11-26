<?php

namespace App\Client;

trait MoviesDatabaseClientTrait
{
    public function getHeaders(): array
    {
        return [
            MoviesDatabaseClient::API_KEY_HEADER_NAME => $this->movieDatabaseApiKey,
        ];
    }
}
