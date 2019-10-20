<?php

namespace VirtualCard\Service\Factory;

use VirtualCard\Traits\EntityManagerAware;

abstract class AbstractFactory
{
    use EntityManagerAware;
    
    public function persist($object): void
    {
        $this->em->persist($object);
    }
    
    public function flush(): void
    {
        $this->em->flush();
    }
}
