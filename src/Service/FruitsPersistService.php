<?php

namespace App\Service;

use App\Event\FruitsAddedEvent;
use App\Repository\FruitRepository;
use App\Subscribers\FruitsAddedSubscriber;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class FruitsPersistService
{
    const SUCCESS = 'success';

    private FruitRepository $fruitRepository;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(
        FruitRepository $fruitRepository,
        EventDispatcherInterface $eventDispatcher,
        FruitsAddedSubscriber $fruitsAddedSubscriber
    ) {
        $this->fruitRepository = $fruitRepository;
        $this->eventDispatcher = $eventDispatcher;

        $this->eventDispatcher->addSubscriber($fruitsAddedSubscriber);
    }

    /**
     * Save API response
     * 
     * @param $data JSON data from API response converted to Array
     * 
     * @return string Status 'success' string if haven't exception -- in other case error message 
     */
    public function save(array $data): string
    {
        $added = [];

        try {
            $added = $this->fruitRepository->saveApiResponse($data, true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        if (count($added) > 0) {
            $fruits = $this->fruitRepository->getFruitsList($added);
            $this->eventDispatcher->dispatch(
                new FruitsAddedEvent($fruits),
                FruitsAddedEvent::NAME
            );
        }

        return self::SUCCESS;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->fruitRepository->findAll();
    }
}