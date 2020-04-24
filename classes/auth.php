<?php

$testRequest = new AuthenticateRequest;
class AuthenticateRequest
{
    public function __construct()
    {
        $dbConnect = new DBConnect();
        $this->db = $dbConnect->pdo;
    }
    public function testAuthentic($uniqueKey)
    {
        echo json_encode("apiKey found, testing...");
        header("HTTP/1.1 403 Forbidden");
        $sql = null;
        $parameters = null;
        $sql = " SELECT * FROM users WHERE userAuth = :userAuth ";
        $parameters = ['userAuth' => $uniqueKey];
        $stmt = $this->db->prepare($sql);
        $stmt->execute($parameters);
        $row = $stmt->fetch();
        if ($row) {
            echo json_encode("Authentification accepted");
        } else {
            echo json_encode("There was an error with your authentification. please re-enter your API key or request a new one");
            die;
        }
    }
}

?>