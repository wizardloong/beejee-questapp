<?php

namespace Infrastructure\App\ReadModel;

use App\Entity\Quest;
use App\ReadModel\QuestReadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Psr\Container\ContainerInterface;

class QuestReadRepositoryFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /**
         * @var EntityManagerInterface $em
         * @var EntityRepository $repository
         */
        $em = $container->get(EntityManagerInterface::class);
        $repository =  $em->getRepository(Quest::class);

        return new QuestReadRepository($repository);
    }
}
