<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VentaStatsController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(): Response
    {
        $productoMasVendido = $this->getProductoMasVendido();

        if ($productoMasVendido === null) {
            return new Response('No hay productos vendidos aún.', Response::HTTP_NOT_FOUND);
        }

        return new Response(sprintf(
            'El producto más vendido es el ID: %d, con un total de %d ventas.',
            $productoMasVendido['productoId'],
            $productoMasVendido['cantidad']
        ));
    }

    private function getProductoMasVendido(): ?array
    {
        // Consultar la base de datos para obtener el producto más vendido
        $query = $this->entityManager->createQuery('
            SELECT IDENTITY(lf.producto) as productoId, COUNT(lf.id) as cantidad
            FROM App\Entity\LineaFactura lf
            GROUP BY lf.producto
            ORDER BY cantidad DESC
        ');

        $result = $query->setMaxResults(1)->getResult();

        if (!$result) {
            return null;
        }

        return [
            'productoId' => reset($result)['productoId'],
            'cantidad' => reset($result)['cantidad'],
        ];
    }
}
