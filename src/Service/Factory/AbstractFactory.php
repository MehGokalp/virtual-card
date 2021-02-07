<?php

namespace VirtualCard\Service\Factory;

use VirtualCard\Traits\EntityManagerAware;

abstract class AbstractFactory
{
    use EntityManagerAware;

    public function persist($object): void
    {
        $this->entityManager->persist($object);
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}
