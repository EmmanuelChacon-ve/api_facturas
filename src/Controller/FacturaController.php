<?php

namespace App\Controller;

use App\Entity\Factura;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class FacturaController extends AbstractController
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;
    private ManagerRegistry $doctrine;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator, ManagerRegistry $doctrine)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->doctrine = $doctrine;
    }

    #[Route('/factura', name: 'app_factura', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $facturas = $this->doctrine->getRepository(Factura::class)->findAll();

        // Serializar la lista de facturas con el grupo 'read'
        $serializedData = $this->serializer->serialize($facturas, 'json', ['groups' => ['read']]);

        return new JsonResponse($serializedData, 200, [], true);
    }

    #[Route('/factura', name: 'app_create_factura', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Deserializar los datos con el grupo 'write'
        $factura = $this->serializer->deserialize($data, Factura::class, 'json', ['groups' => ['write']]);

        // Validar la entidad
        $errors = $this->validator->validate($factura);

        if (count($errors) > 0) {
            $errorMessages = [];

            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()][] = $error->getMessage();
            }

            return new JsonResponse(['errors' => $errorMessages], 400);
        }

        // Guardar la factura en la base de datos utilizando el EntityManager
        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($factura);
        $entityManager->flush();

        // Serializar la factura creada con el grupo 'read'
        $serializedData = $this->serializer->serialize($factura, 'json', ['groups' => ['read']]);

        return new JsonResponse($serializedData, 201, [], true);
    }
}
