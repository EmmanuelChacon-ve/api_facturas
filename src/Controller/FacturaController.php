<?php
namespace App\Controller;
use App\Entity\Cliente;
use App\Entity\Factura;
use App\Repository\FacturaRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class FacturaController extends AbstractController
{
    private FacturaRepository $facturaRepository;

    public function __construct(FacturaRepository $facturaRepository)
    {
        $this->facturaRepository = $facturaRepository;
    }

  
        public function __invoke(Cliente $cliente): JsonResponse
        {
            // Obtener la cantidad de facturas asociadas al cliente
            $cantidadFacturas = count($cliente->getFacturas());
    
            return new JsonResponse(['cliente_id' => $cliente->getId(), 'cantidad_facturas' => $cantidadFacturas]);
        }
    }

