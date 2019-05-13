<?php
// Allow any site to fetch this result.
header("Access-Control-Allow-Origin: *");
// Set header to let browser know to expect json instead of html.
header("Content-Type: application/json; charset=UTF-8");
// Publisher class.
include_once '../classes/publishers.php';
$publisher_object = new \wiesapi\Publishers();
// Check if querystring is set to look for id or number of publishers.
$no_of_publishers = $_GET['no'] ?? null; // What does ?? mean?
$publisherId = $_GET['publisherId'] ?? null;
// Get publishers.
$publishers = $publisher_object->getPublisher($publisherId, $no_of_publishers); // Get the actual publishers.
/* Setup response structure. The response for one publisher should look something like this:
    {"info":{"posts":1,"message":"Everything was ok"},"results":[{"productCode":"S10_1678","productName":"1969 Harley Davidson Ultimate Chopper","productImage":"","productLine":"Motorcycles","productScale":"1:10","productVendor":"Min Lin Diecast","productDescription":"This replica features working kickstand, front suspension, gear-shift lever, footbrake lever, drive chain, wheels and steering. All parts are particularly delicate due to their precise scale and require special care and attention.","quantityInStock":"7933","buyPrice":"48.81","MSRP":"95.70"}]}
    Note that you already have the product structure in $products.
*/
$response = [
    'info' => ['posts' => count($publishers)],
    'results' => $publishers
    // Something.
];
// Different response depending on if we get any products or not.
if ($publishers) {
    http_response_code(200);

    $response['info']['message'] = 'Everything was ok!';
    // Set a suitable http response code. How do you do that in PHP?
    // Set a message in the info property to announce that everything went ok.
} else {
    http_response_code(404);
    $response['info']['message'] = 'No products found';
    // Set a suitable http response code.
    // If we look at $products, what does it mean that we ended up in this else block?
    // What would be a suitable response code?
    // Set a message in the info property to give a readable status to the user.
}
// Format response.
// In order to send back json data, we would actually just print the data in json format.
echo json_encode($response);

?>