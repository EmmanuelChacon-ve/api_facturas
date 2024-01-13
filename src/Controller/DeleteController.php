<?php

namespace App\Controller;

use App\Entity\Cliente;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeleteController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(Cliente $cliente): Response
    {
        // Verificar si el cliente ya ha sido eliminado lógicamente
        if ($cliente->getDeleteAt() !== null) {
            throw new BadRequestHttpException('El cliente ya ha sido eliminado lógicamente.');
        }

        // Realizar el borrado lógico
        $cliente->setDeleteAt(new \DateTimeImmutable());

        // Guardar los cambios en la base de datos
        $this->entityManager->flush();

        // Devolver una respuesta JSON indicando el éxito del borrado lógico
        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}