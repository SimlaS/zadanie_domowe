<?php
require __DIR__.'/vendor/autoload.php';

$client = new \GuzzleHttp\Client([
    'base_url' => 'http://localhost:8000',
    'defaults' => [
        'exceptions' => false
    ]
]);

// 1) Pobieranie listy produktów, które znajdują się na składzie

$response = $client->get('/products/onstore');
echo "\n\n";
echo "1) Pobieranie listy produktów, które znajdują się na składzie";
echo "\n\n";
echo $response;
echo "\n\n";

// 2) Pobieranie listy produktów, które nie znajdują się na składzie

$response = $client->get('/products/missing');
echo "2) Pobieranie listy produktów, które nie znajdują się na składzie";
echo "\n\n";
echo $response;
echo "\n\n";

// 3) Pobieranie listy produktów, które znajdują się na składzie w ilości > 5

$response = $client->get('/products/five');
echo "3) Pobieranie listy produktów, które znajdują się na składzie w ilości > 5";
echo "\n\n";
echo $response;
echo "\n\n";


// 4) Edycja produktu {id = 2}
$data = array(
		'name' => 'Edycja nazwy',
		'amount' => 12
	);

 $response = $client->put('/products/2', [
	'body' => json_encode($data)
]);
echo "4) Edycja produktu {id = 2}";
echo "\n\n";
echo $response;
echo "\n\n";

// 5) Usunięcie produktu {id = 5}

$response = $client->delete('/products/5');
echo "5) Usuniecie produktu {id = 5}";
echo "\n\n";
echo $response;
echo "\n";


// 6) Dodanie nowego produktu
$newProduct = 'Produkt '.rand(0, 999);
$newAmount = rand(0, 999);
$data = array(
    'name' => $newProduct,
    'amount' => $newAmount
);
 $response = $client->post('/products', [
	'body' => json_encode($data)
]);
echo "6) Dodanie nowego produktu";
echo "\n\n";
echo $response;
echo "\n\n";




