<?php
namespace wiesapi;
include_once 'db.php';
use \PDO;
class Publishers
{
    private $db;
    public function __construct()
    {
        $obj = new DB();
        $this->db = $obj->pdo;
    }

    public function createPublisher($data)
    {
        // Setup query.
        $sql = 'INSERT INTO publishers (publisherName) VALUES (:publisherName)';
        // Prepare query.
        $statement = $this->db->prepare($sql);
        // Bind values.
        $statement->bindValue('publisherName', filter_var($data->publisherName, FILTER_SANITIZE_STRING));
        // Execute query and return result.
        return $statement->execute();
    }

    public function getPublisher($id = null, $limit = null)
    {
        // Setup query.
        $sql = 'SELECT * FROM publishers';
        $parameters = null;
        if ($id !== null) {
            // If caller has provided id, then let's just look for that one publisher.
            $sql .= " WHERE publisherId = :publisherId ";
            $parameters = ['publisherId' => $id];
        } elseif ($limit !== null) {
            // If caller want's to limit the number of publishers.
            $sql .= ' LIMIT ' . $limit;
        }
        $statement = $this->db->prepare($sql);
        $statement->execute($parameters);
        // Setup array to contain publishers.
        $publishers = [];
        // Fetch is faster than fetchall.
        while ($row = $statement->fetch()) {
            // Extract $row['publisherId'] to $publisherId etc.
            extract($row);
    
            // Setup structure for publisher item.
            $publisher_item = [
                'publisherId'    => $publisherId,
                'publisherName'  => $publisherName
            ];
    
            // Add product item to products array.
            array_push($publishers, $publisher_item);
        }
        return $publishers;
    }

    // public function update($data){
    //     $sql = 'UPDATE publishers SET';
    //     foreach($data as $field_name => $field_value){

    //     }   
    //     ' WHERE publisherId = :publisherId ';
    //     // Prepare query.
    //     $statement = $this->db->prepare($sql);
    //     // Bind values.
    //     $statement->bindValue('publisherName', filter_var($data->publisherName, FILTER_SANITIZE_STRING));
    //     // Execute query and return result.
    //     return $statement->execute();
    // }

    // public function getSearchProducts($search, $fields = null)
    // {
    //     // Add wildcards to search term.
    //     $search = "%$search%";
    //     // Default fields to search in.
    //     $fields = $fields ?? ['productName', 'productDescription'];
    //     $sql = "SELECT * FROM products ";
    //     // Add all selected fields to query.
    //     foreach ($fields as &$field) {
    //         $field .= ' LIKE :search ';
    //     }
    //     // Build WHERE term in sql query.
    //     $sql .= ' WHERE ' . join(' OR ', $fields);
    //     $statement = $this->db->prepare($sql);
    //     $statement->execute([':search' => $search]);
    //     // Setup array to contain products.
    //     $products = [];
    //     // Fetch is faster than fetchall.
    //     while ($row = $statement->fetch()) {
    //         // Extract $row['productCode'] to $productCode etc.
    //         extract($row);
    
    //         // Setup structure for product item.
    //         $product_item = [
    //             'productCode'        => $productCode,
    //             'productName'        => $productName,
    //             // 'productImage'       => $productImage,
    //             'productLine'        => $productLine,
    //             'productScale'       => $productScale,
    //             'productVendor'      => $productVendor,
    //             'productDescription' => $productDescription,
    //             'quantityInStock'    => $quantityInStock,
    //             'buyPrice'           => $buyPrice,
    //             'MSRP'               => $MSRP
    //         ];
    //         // Add product item to products array.
    //         array_push($products, $product_item);
    //     }
    //     return $products;
    // }
}