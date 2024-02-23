<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Log;
use DateTimeImmutable;

class LogController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createLog(Request $request)
    {
        $method = $request->getMethod();
        $url = $request->getUri();
        $params = $request->query->all();
        $createdAt = new DateTimeImmutable(); // Fecha y hora actual

        $log = new Log();
        $log->setLevel('info');
        $log->setMessage('Request received');
        $log->setRequestMethod($method);
        $log->setRequestUrl($url);
        $log->setRequestParams(json_encode($params));
        $log->setCreatedAt($createdAt); // Establecer la fecha y hora actual

        $this->entityManager->persist($log);
        $this->entityManager->flush();

        return $log; 
    }
}
