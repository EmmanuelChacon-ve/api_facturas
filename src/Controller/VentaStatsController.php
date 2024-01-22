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
        // Utilizar QueryBuilder para construir la consulta
        $qb = $this->entityManager->createQueryBuilder();
        $productoMasVendido = $qb
            ->select('IDENTITY(lf.producto) as productoId, COUNT(lf.id) as cantidad')
            ->from('App\Entity\LineaFactura', 'lf')
            ->groupBy('lf.producto')
            ->orderBy('cantidad', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        if (!$productoMasVendido) {
            return null;
        }

        return [
            'productoId' => reset($productoMasVendido)['productoId'],
            'cantidad' => reset($productoMasVendido)['cantidad'],
        ];
    }
}
