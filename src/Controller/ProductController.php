<?php

namespace App\Controller;

use App\Entity\Product;
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

    private function getErrors($message){
        return new JsonResponse([
            'status'=>'fail',
            'message'=>$message
        ],404,['Content-Type' => 'application/json']);
    }
    private function getFoundedProduct($data){
        return new JsonResponse([
            'status'=>'success',
            'data'=>$data
        ],200,['Content-Type' => 'application/json']);
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

        $errors = $validator->validate($product);

        if(count($errors) > 0){
            return new JsonResponse([
                'status'=>'fail',
                'errors'=>$this->getValidationMessages($errors)
            ]);
        }

        $entityManager->persist($product);

        try {
            $entityManager->flush();
        }catch (Exception $ex){
            return $this->getErrors($ex->getMessage());
        }

        return $this->getFoundedProduct($product);
    }


    #[Route('/product',name:'show_products' ,methods: ['GET'])]
    public function show(ManagerRegistry $doctrine): JsonResponse
    {
        $entityManager = $doctrine->getRepository(Product::class);
        $products = $entityManager->findAll();

        if(!$products){
            return $this->getErrors('Products not founded');
        }
        return $this->getFoundedProduct($products);
    }


    #[Route('/product/{id}',name:'show_product_by_id' ,methods: ['GET'])]
    public function showProductById(int $id, ManagerRegistry $doctrine){
        $entityManager = $doctrine->getRepository(Product::class);
        $product = $entityManager->find($id);

        if(!$product){
            return $this->getErrors('Product with that specific id not founded');
        }
        return $this->getFoundedProduct($product);
    }

    #[Route('/product/{id}',name:'show_product_by_id' ,methods: ['PUT'])]
    public function update(int $id, Request $request, ManagerRegistry $doctrine):JsonResponse{

        $data = json_decode($request->getContent(),true);
        $entityManager = $doctrine->getManager();


        $product = $entityManager->getRepository(Product::class)->find($id);
        if(!$product){
            return $this->getErrors('Product not founded');
        }

        isset($data['name']) && $product->setName($data['name']);
        isset($data['price']) && $product->setPrice($data['price']);
        isset($data['stock']) && $product->setStock($data['stock']);
        isset($data['description']) && $product->setDescription($data['description']);
        $product->setUpdatedAt(new \DateTimeImmutable());


        try {
            $entityManager->flush();
        }catch (Exception $ex){
            return $this->getErrors($ex->getMessage());
        }
        return $this->getFoundedProduct($product);
    }

    #[Route('/product/{id}',name:'show_product_by_id' ,methods: ['Delete'])]
    public function delete(int $id, ManagerRegistry $doctrine):JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        if(!$product){
            return $this->getErrors('Product not founded');
        }

        $entityManager->remove($product);
        try {
            $entityManager->flush();
        }catch (Exception $ex){
            return $this->getErrors($ex->getMessage());
        }

        return new JsonResponse(['status'=>'success'],200,['Content-type'=>'application/json']);
    }

}
