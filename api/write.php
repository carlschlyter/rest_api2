<?php
// Allow any site to fetch this result.
header("Access-Control-Allow-Origin: *");
// Set header to let browser know to expect json instead of html.
header("Content-Type: application/json; charset=UTF-8");
// Setup POST to be the only acceptable way to contact this page.
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// Publishers class.
include_once '../classes/publishers.php';
$publisher_object = new \wiesapi\Publishers();
// Get the posted data.
// Ok, so this isn't self explanatory, but what does this do? Google it!
$publisher_data = json_decode(file_get_contents('php://input'));
// Setup response structure.
$response = [
    'results' => null
];
// Try to create publisher.
// Create similar responses as in the read.php file, depending on if the product
// was successfully created or not.
if ($publisher_object->createPublisher($publisher_data)/* product was successfully created */) {
    http_response_code(201);

    $response['info']['message'] = 'Publisher items created!';
    $response['results'] = $publisher_data;
    // Set a suitable response code.
    // Set a readable message.
    // Add the newly created product to results.
} else {
    http_response_code(503);
    $response['info']['message'] = 'Publisher items not created';
    // Set a suitable response code.
    // Set a readable message.
}
echo json_encode($response);
// Format response.
// Same as last one.