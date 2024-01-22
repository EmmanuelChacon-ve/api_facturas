<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Metadata\ResourceClassResolverInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Producto;
use App\Entity\LineaFactura;

class StockController extends AbstractController
{
    private $entityManager;
    private $resourceClassResolver;
    private $validator;

    public function __construct(EntityManagerInterface $entityManager, ResourceClassResolverInterface $resourceClassResolver, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->resourceClassResolver = $resourceClassResolver;
        $this->validator = $validator;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->validateRequest($request);

        $ventasMes = $this->getVentasMes();

        $productosPedir = $this->calcularProductosAPedir($ventasMes);

        return new JsonResponse(['productos_a_pedir' => $productosPedir]);
    }

    private function validateRequest(Request $request): void
    {
        $resourceClass = LineaFactura::class; // Utiliza directamente la clase de recurso
        $this->validator->validate($request->attributes->all(), null, $resourceClass);
    }

    private function getVentasMes(): array
    {
        // Consultar las ventas del mes actual
        $ventasMes = $this->entityManager->getRepository(LineaFactura::class)
            ->createQueryBuilder('lf')
            ->select('IDENTITY(lf.producto) as producto_id, COUNT(lf.id) as cantidad_ventas')
            ->where('lf.createdAt >= :primerDiaMes AND lf.createdAt <= :ultimoDiaMes')
            ->setParameter('primerDiaMes', new \DateTimeImmutable('first day of this month midnight'))
            ->setParameter('ultimoDiaMes', new \DateTimeImmutable('last day of this month midnight'))
            ->groupBy('lf.producto')
            ->getQuery()
            ->getResult();

        return $ventasMes;
    }

    private function calcularProductosAPedir(array $ventasMes): array
{
    $productosPedir = [];

    // Obtener el stock máximo permitido
    $stockMaximo = 30;

    // Calcular productos a pedir para el próximo mes
    foreach ($ventasMes as $venta) {
        // Verificar si la clave 'cantidad_ventas' existe en el array
        if (array_key_exists('cantidad_ventas', $venta)) {
            $productoId = $venta['producto_id'];
            $cantidadVendida = $venta['cantidad_ventas'];

            // Obtener el nombre del producto
            $nombreProducto = $this->getNombreProducto($productoId);

            $stockActual = $stockMaximo - $cantidadVendida;

            if ($stockActual < 0) {
                $stockActual = 0;
            }

            $productosPedir[$nombreProducto] = $stockActual;
        } else {

             new JsonResponse(['error' => 'La clave "cantidad_ventas" no está presente en el array.']);
        }
    }

    return $productosPedir;
}

private function getNombreProducto(int $productoId): string
{
    // Obtener el nombre del producto
    $producto = $this->entityManager->getRepository(Producto::class)->find($productoId);

    return $producto ? $producto->getName() : 'Producto Desconocido';
}
}
