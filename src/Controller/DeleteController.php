<?php

namespace App\Controller;

use App\Entity\Cliente;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
/* 
     #[Route('/api/delete/clientes/{id}', name: 'app_delete')] */
    public function delete(Cliente $cliente): JsonResponse
    {
        // Verificar si el cliente ya ha sido eliminado lógicamente
        if ($cliente->getDeleteAt() !== null) {
            return new JsonResponse(['message' => 'El cliente ya ha sido eliminado lógicamente.'], Response::HTTP_BAD_REQUEST);
        }

        // Realizar el borrado lógico
        $cliente->setDeleteAt(new \DateTimeImmutable());

        // Guardar los cambios en la base de datos
        $this->entityManager->flush();

        // Devolver una respuesta JSON indicando el éxito del borrado lógico
        return new JsonResponse(['message' => 'Borrado lógico exitoso']);
    }    
    


}
