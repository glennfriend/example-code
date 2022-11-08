<?php

namespace App\Services;

class Account
{
    /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function findByAccountId(int $accountId): array
    {
        $payload = [
            'filter' => [
                'account_id' => $accountId,
            ],
        ];
        $resource = "account";

        $url = $this->client->getEndPoint($resource);
        $response = $this->client->request('GET', $url, $payload);
        return json_decode($response->getBody(), true);
    }
}
