<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use App\Controller\LogController;

class RequestListener
{
    private $logController;

    public function __construct(LogController $logController)
    {
        $this->logController = $logController;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $this->logController->createLog($event->getRequest());
    }
}