<?php
namespace Tests\SlawekBundle\Controller;
use Tests\SlawekBundle\ApiTestCase;

class ProductControllerTest extends ApiTestCase
{
	public function testPost()
	{
        // Testowanie dodawania nowego produktu
        $newProduct = 'Produkt';
		$newAmount = rand(0, 999);
		$data = array(
		    'name' => $newProduct,
		    'amount' => $newAmount
		);

		$response = $this->client->post('/products', [
			    'body' => json_encode($data)
			]);

		$this->assertEquals(201, $response->getStatusCode());
		$returnArray = json_decode($response->getBody(true),true);
		$this->assertArrayHasKey('amount',$returnArray);
		$this->assertEquals('Produkt',$returnArray['name']);
	}

	public function testGetProductsCollection()
	{
		$response = $this->client->get('/products');
		$this->assertEquals(200,$response->getStatusCode());
		$returnArray = json_decode($response->getBody(true),true);
		$this->assertEquals(array('products'),array_keys($returnArray));
	}

	public function testPutProduct()
	{
		$data = array(
			'id'=>2,
			'name' => 'Zmieniona nazwa',
			'amount' => 0
		);
		 $response = $this->client->put('/products/2', [
            'body' => json_encode($data)
        ]);
		 $this->assertEquals(200,$response->getStatusCode());
		 $returnArray = json_decode($response->getBody(true),true);
		 $this->assertEquals('Zmieniona nazwa',$returnArray['name']);
	}

	public function testDeleteProduct()
	{
		$response = $this->client->delete('/products/10');
        $this->assertEquals(204, $response->getStatusCode());
	}

}