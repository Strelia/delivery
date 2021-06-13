<?php

namespace App\EventSubscriber;

use App\Entity\CargoRequest;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Workflow\Event\Event;
use Symfony\Component\Workflow\Event\GuardEvent;

class CargoRequestWorkflowSubscriber implements EventSubscriberInterface
{
    private LoggerInterface $logger;
    private EntityManagerInterface $em;
    private User $user;

    /**
     * CargoRequestWorkflowSubscriber constructor.
     * @param TokenStorageInterface $tokenStorage
     * @param LoggerInterface $logger
     * @param EntityManagerInterface $em
     */
    public function __construct(TokenStorageInterface $tokenStorage, LoggerInterface $logger, EntityManagerInterface $em)
    {
        $this->logger = $logger;
        $this->em = $em;
        $this->user = $tokenStorage->getToken()->getUser();
    }


    public function onWorkflowCargoRequestEnter(Event $event)
    {
        $this->logger->debug('on enter', [
            'marking - places' => $event->getMarking()->getPlaces(),
            'transition' => $event->getTransition()->getName(),
        ]);
    }

    public function onWorkflowCargoRequestLeave(Event $event)
    {
        $this->logger->debug('on leave', [
            'marking - places' => $event->getMarking()->getPlaces(),
            'transition' => $event->getTransition()->getName(),
        ]);
    }

    public function onWorkflowCargoRequestTransition(Event $event)
    {
        $this->logger->debug('on transition', [
            'marking - places' => $event->getMarking()->getPlaces(),
            'transition' => $event->getTransition()->getName(),
        ]);
    }

    public function onWorkflowCargoRequestGuard(GuardEvent $event)
    {
//        $event->setBlocked(true, 'This blog post cannot be marked as reviewed because it has no title.');
        /**
         * @var CargoRequest $cargoReq
         */
        $cargoReq = $event->getSubject();

//        dd($event);
    }


    public function onWorkflowCargoRequest(Event $event) {
//        dd($event);
    }

    public static function getSubscribedEvents(): array
    {
        return [
//            'workflow.cargo_request.enter' => 'onWorkflowCargoRequestEnter',
//            'workflow.cargo_request.leave' => 'onWorkflowCargoRequestLeave',
//            'workflow.cargo_request.transition' => 'onWorkflowCargoRequestTransition',
            'workflow.cargo_request' => 'onWorkflowCargoRequest',
            'workflow.cargo_request.guard' => 'onWorkflowCargoRequestGuard'
        ];
    }
}
