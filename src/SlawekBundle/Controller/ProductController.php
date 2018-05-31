<?php

namespace SlawekBundle\Controller;
use SlawekBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
	/**
	 * Zwraca listę produktów w zależności od parametu
	 * @Route("/products",defaults={"parameter" = "all"})
     * @Route("/products/{parameter}")
     * @Method("GET")
     */
	public function listAction($parameter)
	{
        $prodRep = $this->getDoctrine()
            ->getRepository('SlawekBundle:Product');
        switch ($parameter) {
            case 'onstore':
                $products = $prodRep->findAllByAmountGreaterThan(0);
                break;
            case 'missing':
                $products = $prodRep->findByAmount(0);
                break;
            case 'five':
                $products = $prodRep->findAllByAmountGreaterThan(5);
                break;
            
            default:
                $products = $prodRep->findAll();
                break;
        }
		$data = array(
			'products' => array()
		);
		foreach($products as $product){
			$data['products'][] = $this->serializeProduct($product);
		}

		$response = new JsonResponse($data, 200);
		return $response;
	}
	/**
	 * Dodaje nowy produkt
     * @Route("/products")
     * @Method("POST")
     */
	public function newAction(Request $request)
    {
    	$data = json_decode($request->getContent(), true);
    	$product = new Product();
    	$product->setName($data['name']);
    	$product->setAmount($data['amount']);

    	$em = $this->getDoctrine()->getManager();
    	$em->persist($product);
        $em->flush();

        $data = $this->serializeProduct($product);
        $response = new JsonResponse($data, 201);
        return $response;

    }
    /**
     * Aktualizuje produkt dla klucza o numerze id
     * @Route("/products/{id}")
     * @Method("PUT")
     */
    public function updateAction($id, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $product = $this->getDoctrine()
            ->getRepository('SlawekBundle:Product')
            ->findOneById($id);
        if(!$product){
            throw $this->createNotFoundException(sprintf(
                'Nie znaleziono produktu z id "%s"',
                $id
            ));
        }

        $product->setName($data['name']);
        $product->setAmount($data['amount']);

        $em = $this->getDoctrine()->getManager();
        $em->merge($product);
        $em->flush();
        $data = $this->serializeProduct($product);

        $response = new JsonResponse($data, 200);
        return $response;
       
    }

    /**
     * @Route("/products/{id}")
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {
        $product = $this->getDoctrine()
            ->getRepository('SlawekBundle:Product')
            ->findOneById($id);
        if($product){
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }
        return new Response(null, 204);
    }

    private function serializeProduct(Product $product)
    {
        return array(
        	'id' => $product->getId(),
            'name' => $product->getName(),
            'amount' => $product->getAmount(),
        );
    }


}
