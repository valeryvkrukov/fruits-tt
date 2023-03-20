<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class FruityViceClientService
{
    public function __construct(
        private HttpClientInterface $fruityviceClient
    ) {  
    }

    /**
     * Fetch data from https://fruityvice.com/ 
     * 
     * @param $mode Correct values 'all', 'family', 'genus', 'order' -- for other will be thrown HTTP error.
     * @param $param For mode 'all' it's a null for others should contain value of field related to used $mode
     * 
     * @return array|string Array with data will be returned, if error thrown -- string with error.
     */
    public function fetchData(string $mode = 'all', string $param = null): array|string
    {
        $uri = implode('/', [$mode, ($param) ?? null]);

        try {
            return $this->fruityviceClient->request('GET', $uri)->toArray();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}