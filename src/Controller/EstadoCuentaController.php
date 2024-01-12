<?php

namespace App\Controller;

use App\Entity\EstadoCuenta;
use App\Repository\EstadoCuentaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EstadoCuentaController extends AbstractController
{
    private EstadoCuentaRepository $estadoCuentaRepository;

    public function __construct(EstadoCuentaRepository $estadoCuentaRepository)
    {
        $this->estadoCuentaRepository = $estadoCuentaRepository;
    }

    #[Route('/api/estado_cuenta/{facturaId}/calcular_saldo', name: 'app_calcular_saldo', methods: ['GET'])]
    public function calcularSaldo(int $facturaId): JsonResponse
    {
        // Obtener el estado de cuenta para la factura específica
        $estadoCuenta = $this->estadoCuentaRepository->findOneBy(['factura' => $facturaId]);

        if ($estadoCuenta === null) {
            return new JsonResponse(['message' => 'No se encontró el estado de cuenta para la factura.'], Response::HTTP_NOT_FOUND);
        }

        // Calcular el resultado (restar saldo pendiente del saldo actual)
        $resultado = $estadoCuenta->getSaldoActual() - $estadoCuenta->getMontoPendiente();

        // Devolver el resultado
        return new JsonResponse(['resultado' => $resultado]);
    }
}
