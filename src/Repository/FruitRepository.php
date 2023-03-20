<?php

namespace App\Repository;

use App\Entity\Fruit;
use App\Entity\Nutritions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fruit>
 *
 * @method Fruit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fruit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fruit[]    findAll()
 * @method Fruit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FruitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fruit::class);
    }

    public function save(Fruit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Fruit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Create new records using API response
     * If item (App\Entity\Fruit) with same ID already exists 
     * record would be updated instead of creation
     */
    public function saveApiResponse(array $data, bool $flush = false): array
    {
        $loaded = $this->getLoaded($data);
        $added = [];
        
        foreach ($data as $item) {
            $alreadyExists = array_key_exists($item['id'], $loaded);

            if ($alreadyExists) {
                $fruit = $loaded[$item['id']];
            } else {
                $fruit = new Fruit();
                $added[] = $item['id'];
            }
            
            foreach ($item as $name => $value) {
                $method = 'set' . ucfirst($name);
                if ($name !== 'nutritions') {
                    $fruit->$method($value);
                } else {
                    $nutritions = new Nutritions();
                    
                    foreach ($value as $nutritionsName => $nutritionsValue) {
                        $nutritionsMethod = 'set' . ucfirst($nutritionsName);
                        $nutritions->$nutritionsMethod($nutritionsValue);
                    }

                    $fruit->$method($nutritions);
                    $nutritions->setFruit($fruit);

                    $this->getEntityManager()->persist($nutritions);
                }
            }

            $this->getEntityManager()->persist($fruit);
        }

        if ($flush) {
            $this->getEntityManager()->flush();
        }

        return $added;
    }

    /**
     * Get currently loaded items by ID's list
     * Method just for internal use
     */
    protected function getLoaded(array $data): array
    {
        $ids = array_column($data, 'id');

        $dql = sprintf('SELECT f FROM %s f WHERE f.id IN (:ids)', Fruit::class);
        $loaded = $this->getEntityManager()->createQuery($dql)->setParameter('ids', $ids)->getResult();

        $result = [];

        foreach ($loaded as $fruit) {
            $result[$fruit->getId()] = $fruit;
        }

        return $result;
    }

    public function getFruitsList(array $ids): array
    {
        $dql = sprintf('SELECT f FROM %s f WHERE f.id IN (:ids)', Fruit::class);

        return $this
            ->getEntityManager()
            ->createQuery($dql)
            ->setParameter('ids', $ids)
            ->getArrayResult()
        ;
    }
}