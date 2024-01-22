<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ResumenCajaController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function __invoke(Request $request): Response
    {
        // Obtener la fecha del parámetro de la solicitud, o usar la fecha actual
        $fecha = $request->query->get('fecha', date('Y-m-d'));

        $resumenCaja = $this->getResumenCaja($fecha);

        if ($resumenCaja === null) {
            return new Response('No hay facturas para la fecha especificada.', Response::HTTP_NOT_FOUND);
        }

        return $this->json($resumenCaja);
    }

    private function getResumenCaja(string $fecha): ?array
    {
        // Utilizar QueryBuilder para construir la consulta 
        $qb = $this->entityManager->createQueryBuilder();
        $resumenCaja = $qb
            ->select('SUM(lf.subtotal) as totalEfectivo', 'COUNT(f.id) as totalFacturas')
            ->from('App\Entity\Factura', 'f')
            ->join('f.lineasfacturas', 'lf')
            ->where($qb->expr()->eq('f.createdAt', ':fecha'))
            ->setParameter('fecha', new \DateTime($fecha))
            ->getQuery()
            ->getResult();
    
        if (!$resumenCaja) {
            return null;
        }
    
        return [
            'totalEfectivo' => reset($resumenCaja)['totalEfectivo'],
            'totalFacturas' => reset($resumenCaja)['totalFacturas'],
            'fecha' => $fecha,
        ];
    }
    
    
}
