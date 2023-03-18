<?php

namespace App\Service;

use App\Repository\FruitRepository;

class FruitsPersistService
{
    const SUCCESS = 'success';

    public function __construct(
        private FruitRepository $fruitRepository
    ) {
    }

    /**
     * Save API response
     */
    public function save(array $data): string
    {
        try {
            $this->fruitRepository->saveApiResponse($data, true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return self::SUCCESS;
    }

    public function all(): array
    {
        return $this->fruitRepository->findAll();
    }
}