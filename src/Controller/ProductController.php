<?php

namespace App\Controller;

use App\Entity\Product;
use DateTimeZone;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductController extends AbstractController
{
    private function getValidationMessages($errors): array{
        $messages = [];
        foreach ($errors as $validation){
            $messages[''.$validation->getPropertyPath()] = $validation->getMessage();
        }
        return $messages;
    }


    #[Route('/product',name:'create_product' ,methods: ['POST'])]
    public function create(Request $request,ValidatorInterface $validator, ManagerRegistry  $doctrine): JsonResponse
    {
        $data = json_decode($request->getContent(),true);
        $entityManager = $doctrine->getManager();


        $product = new Product();
        $product->setName($data['name']);
        $product->setDescription($data['description']);
        $product->setPrice($data['price']);
        $product->setStock($data['stock']);
        $product->setCreatedAt(new \DateTimeImmutable());
        $entityManager->persist($product);

        $errors = $validator->validate($product);



        if(count($errors) > 0){
            return new JsonResponse([
                'status'=>'fail',
                'errors'=>$this->getValidationMessages($errors)
            ]);
        }



        try {
            $entityManager->flush();
        }catch (Exception $ex){
            return new JsonResponse([
                'status'=>'fail',
                'exception_message'=>$ex->getMessage()
            ]);
        }

        return new JsonResponse([
            'status' => 'Success',
            'data'=>$data
        ]);
    }


    #[Route('/product',name:'show_products' ,methods: ['GET'])]
    public function show(ManagerRegistry $doctrine): JsonResponse
    {
        $entityManager = $doctrine->getRepository(Product::class);
        $products = $entityManager->findAll();

        

        //foreach ($products as $product)
        return new JsonResponse(['status'=>'success','data'=>$products]);
    }


}
