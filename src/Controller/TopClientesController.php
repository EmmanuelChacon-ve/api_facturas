<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Cliente;
use ApiPlatform\Core\Annotation\ApiResource;

class TopClientesController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function __invoke(Request $request): Response
    {
        // Obtener la cantidad de clientes que se desean en la lista
        $cantidadClientes = $request->query->get('cantidad', 10);

        // Obtener la lista de clientes con el mayor monto pagado
        $topClientes = $this->getTopClientesByMontoPagado($cantidadClientes);

        if (empty($topClientes)) {
            return new Response('No hay clientes disponibles.', Response::HTTP_NOT_FOUND);
        }

        return $this->json($topClientes);
    }

    private function getTopClientesByMontoPagado(int $cantidad): array
    {
        // Utilizar QueryBuilder para construir la consulta 
        $qb = $this->entityManager->createQueryBuilder();
        $topClientes = $qb
            ->select('c.id', 'c.name', 'SUM(p.monto) as montoPagado')
            ->from('App\Entity\Cliente', 'c')
            ->leftJoin('c.facturas', 'f')
            ->leftJoin('f.pagos', 'p')
            ->groupBy('c.id')
            ->orderBy('montoPagado', 'DESC')
            ->setMaxResults($cantidad)
            ->getQuery()
            ->getResult();

        return $topClientes;
    }
}
