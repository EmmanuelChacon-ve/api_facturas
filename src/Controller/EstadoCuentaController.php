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

    public function __invoke(EstadoCuenta $estadoCuenta): JsonResponse
    {
        // Calcular el resultado (restar saldo pendiente del saldo actual)
        $resultado = $estadoCuenta->getSaldoActual() - $estadoCuenta->getMontoPendiente();

        // Devolver el resultado
        return new JsonResponse(['resultado' => $resultado]);
    }
}