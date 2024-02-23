<?php
// api/src/EventSubscriber/GeneralEventListener.php

namespace App\EventListener;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Controller\LogController;
use App\Entity\Book;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

final class GeneralEventListener implements EventSubscriberInterface
{
  private $logController;
  private $logger;

  public function __construct(LogController $logController, LoggerInterface $logger)
  {
    $this->logController = $logController;
    $this->logger = $logger;
  }

  public static function getSubscribedEvents()
  {
    return [
      KernelEvents::VIEW => ['postWrite', EventPriorities::POST_WRITE], //used for post and put
    ];
  }

  public function postWrite(ViewEvent $event): void
  {
    // $book = $event->getControllerResult();
    // $method = $event->getRequest()->getMethod();
    $this->logger->debug("enter here");
    $this->logController->createLog($event->getRequest());
  }
}