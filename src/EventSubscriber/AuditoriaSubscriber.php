<?php

namespace App\EventSubscriber;

use App\Entity\Auditoria;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AuditoriaSubscriber implements EventSubscriber
{
    private TokenStorageInterface $tokenStorage;
    private LoggerInterface $logger;
    private $em;
    public function setEntityManager(EntityManagerInterface $em) { $this->em = $em; }

    public function __construct(TokenStorageInterface $tokenStorage, LoggerInterface $logger)
    {
        $this->tokenStorage = $tokenStorage;
        $this->logger = $logger;
        $this->logger->info('[AUDITORIA] AuditoriaSubscriber instanciado');
    }

    public function getSubscribedEvents()
    {
        return [
            'postPersist',
            'preRemove',
            'onFlush'
        ];
    }

    public function onFlush(OnFlushEventArgs $args): void
    {
        $em = $args->getObjectManager();
        $uow = $em->getUnitOfWork();
        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            if ($entity instanceof \App\Entity\Empleado || $entity instanceof \App\Entity\Proyecto) {
                $user = $this->tokenStorage->getToken()?->getUser();
                $username = is_object($user) && method_exists($user, 'getUserIdentifier')
                    ? $user->getUserIdentifier()
                    : 'anon.';
                $audit = new \App\Entity\Auditoria();
                $audit->setUser($username);
                $audit->setEntity((new \ReflectionClass($entity))->getShortName());
                $audit->setActionType('UPDATE');
                $audit->setDateTime(new \DateTime());
                if (method_exists($entity, 'getId')) {
                    $audit->setEntityId($entity->getId());
                }
                $em->persist($audit);
                $uow->computeChangeSet($em->getClassMetadata(\App\Entity\Auditoria::class), $audit);
            }
        }
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if (($entity instanceof \App\Entity\Empleado || $entity instanceof \App\Entity\Proyecto) && $args->getObjectManager() instanceof EntityManagerInterface) {
            $this->setEntityManager($args->getObjectManager());
            $this->registerAudit('CREATE', $entity);
            $this->em->flush(); // Para asegurar que se guarde la auditoría con el ID correcto
        }
    }

    public function preRemove(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if (($entity instanceof \App\Entity\Empleado || $entity instanceof \App\Entity\Proyecto) && $args->getObjectManager() instanceof EntityManagerInterface) {
            $this->setEntityManager($args->getObjectManager());
            $this->registerAudit('DELETE', $entity);
        }
    }

    private function registerAudit(string $actionType, object $entity): void
    {
        $user = $this->tokenStorage->getToken()?->getUser();
        $username = is_object($user) && method_exists($user, 'getUserIdentifier')
            ? $user->getUserIdentifier()
            : 'anon.';
        $audit = new \App\Entity\Auditoria();
        $audit->setUser($username);
        $audit->setEntity((new \ReflectionClass($entity))->getShortName());
        $audit->setActionType($actionType);
        $audit->setDateTime(new \DateTime());
        // Guardar el ID del registro afectado
        if (method_exists($entity, 'getId')) {
            $audit->setEntityId($entity->getId());
        }
        $em = $this->em;
        $em->persist($audit);
    }

    public function postFlush(PostFlushEventArgs $args): void
    {
        // No es necesario flush adicional, Doctrine lo maneja
    }
}
