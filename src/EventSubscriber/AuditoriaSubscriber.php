<?php

namespace App\EventSubscriber;

use App\Entity\Auditoria;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AuditoriaSubscriber implements EventSubscriberInterface
{
    private TokenStorageInterface $tokenStorage;
    private array $pendingAudits = [];
    private bool $flushing = false;
    private LoggerInterface $logger;

    public function __construct(TokenStorageInterface $tokenStorage, LoggerInterface $logger)
    {
        $this->tokenStorage = $tokenStorage;
        $this->logger = $logger;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            Events::prePersist => 'prePersist',
            Events::preUpdate => 'preUpdate',
            Events::preRemove => 'preRemove',
            Events::postFlush => 'postFlush',
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->logger->info('[AUDITORIA] prePersist llamado', ['entity' => get_class($args->getObject())]);
        $this->queueAudit('CREATE', $args);
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $this->logger->info('[AUDITORIA] preUpdate llamado', ['entity' => get_class($args->getObject())]);
        $this->queueAudit('UPDATE', $args);
    }

    public function preRemove(LifecycleEventArgs $args): void
    {
        $this->logger->info('[AUDITORIA] preRemove llamado', ['entity' => get_class($args->getObject())]);
        $this->queueAudit('DELETE', $args);
    }

    private function queueAudit(string $actionType, LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!$this->shouldAudit($entity)) {
            $this->logger->info('[AUDITORIA] Entidad ignorada', ['entity' => get_class($entity)]);
            return;
        }
        $user = $this->tokenStorage->getToken()?->getUser();
        $username = is_object($user) && method_exists($user, 'getUserIdentifier') 
            ? $user->getUserIdentifier() 
            : 'anon.';
        $audit = new Auditoria();
        $audit->setUser($username);
        $audit->setEntity((new \ReflectionClass($entity))->getShortName());
        $audit->setActionType($actionType);
        $audit->setDateTime(new \DateTime());
        $this->logger->info('[AUDITORIA] Audit en cola', [
            'user' => $username,
            'entity' => (new \ReflectionClass($entity))->getShortName(),
            'action' => $actionType
        ]);
        $this->pendingAudits[] = $audit;
    }

    private function shouldAudit(object $entity): bool
    {
        return in_array(get_class($entity), [
            'App\\Entity\\Empleado',
            'App\\Entity\\Proyecto',
        ], true);
    }

    public function postFlush(PostFlushEventArgs $args): void
    {
        $this->logger->info('[AUDITORIA] postFlush llamado', ['pendingAudits' => count($this->pendingAudits)]);
        if (empty($this->pendingAudits) || $this->flushing) {
            $this->logger->info('[AUDITORIA] No hay auditorías pendientes o ya está flusheando.');
            return;
        }
        try {
            $this->flushing = true;
            $em = $args->getObjectManager();
            foreach ($this->pendingAudits as $audit) {
                $this->logger->info('[AUDITORIA] Persistiendo auditoría', [
                    'user' => $audit->getUser(),
                    'entity' => $audit->getEntity(),
                    'action' => $audit->getActionType()
                ]);
                $em->persist($audit);
            }
            $this->pendingAudits = [];
            $em->flush();
        } finally {
            $this->flushing = false;
        }
    }
}
