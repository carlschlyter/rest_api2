<?php

// include "classes/api.php";
// include "classes/authors.php";
// include "classes/books.php";
// include "classes/publishers2.php";
spl_autoload_register(function($class_name){
    if (file_exists('classes/' . $class_name . '.php')) {
        include 'classes/' . $class_name . '.php';
    } else {
        echo 'File not found';
    }
});

// Get URI.
$request_uri = $_SERVER['REQUEST_URI'];
//var_dump($request_uri);

// Get querystring
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);
//var_dump($request_uri);

// Get querystring.
$querystring = $_SERVER["QUERY_STRING"];
//var_dump($querystring);

// Get the querystring parts.
$request_parts = explode('/', $querystring, 2);
//var_dump($request_parts);

// Get request method. (GET, POST etc).
$request_method = strtolower($_SERVER['REQUEST_METHOD']);
//var_dump($request_method);

$class = $request_parts[0];
$args = $request_parts[1] ?? null;
$body_data = json_decode(file_get_contents('php://input'));

$obj = new $class;

//var_dump($obj->get());

$response = [
    'info' => null,
    'results' => null
];

if (empty($class)) {
    http_response_code(400);
} else {
    $obj = new $class;

    // Setup router.
    switch ($request_method) {
        // Delete record.
        case 'delete':
            // Handle delete.
            break;
        // Create record.
        case 'post':
            if ($obj->create($body_data)) {
                http_response_code(201);
                $response['results'] = $body_data;
                $response['info']['no'] = 1;
                $response['info']['message'] = "Item created ok.";
            } else {
                http_response_code(503);
                $response['info']['no'] = 0;
                $response['info']['message'] = "Couldn't create item.";
            }
            break;
        // Update record.
        case 'put':
            if ($obj->update($body_data)) {
                http_response_code(200);
                $response['results'] = $body_data;
                $response['info']['no'] = 1;
                $response['info']['message'] = "Item updated ok.";
            } else {
                http_response_code(503);
                $response['info']['no'] = 0;
                $response['info']['message'] = "Couldn't update item.";
            }
            break;
        
        // Everything else: GET.
        default:
            $data = $obj->get($args);
            if ($data) {
                http_response_code(200);
                $response['info']['no'] = count($data);
                $response['info']['message'] = "Returned items.";
                $response['results'] = $data;
            } else {
                http_response_code(404);
                $response['info']['message'] = "Couldn't find any items.";
                $response['info']['no'] = 0;
            }
            break;
    }
}
header("Content-Type: application/json; charset=UTF-8");
echo json_encode($response);
// var_dump($obj->get());

// $obj = new Books();

// $data = json_decode('{
//     "bookTitle": "The Da Vinci Code",
//     "authorId": "6"
// }');

// $obj->create($data);

// var_dump($obj->get());

// $class = 'Publishers';

// $obj2 = new $class;

// var_dump($obj2->get());

// $obj3 = new Publishers();

// var_dump($obj3->get());

?>