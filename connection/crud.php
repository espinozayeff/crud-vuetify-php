<?php
   include_once 'connection.php';

   $object = new Connection();
   $connection = $object -> Connect();

   $_POST = json_decode(file_get_contents("php://input"), true);

   $operation_type   = (isset($_POST['operation'])) ? $_POST['operation'] : '';
   $id               = (isset($_POST['id'])) ? $_POST['id'] : '';
   $name             = (isset($_POST['name'])) ? $_POST['name'] : '';
   $warehouse        = (isset($_POST['warehouse'])) ? $_POST['warehouse'] : '';
   $status           = (isset($_POST['status'])) ? $_POST['status'] : 0;
   $quantity         = (isset($_POST['quantity'])) ? $_POST['quantity'] : 0;
   $remarks          = (isset($_POST['remarks'])) ? $_POST['remarks'] : '';   
   
   switch ($operation_type) {
      case 1:
         $query = "INSERT INTO product (name, warehouse, status, quantity, remarks) VALUES ('$name', '$warehouse', '$status', '$quantity', '$remarks')";
         $result = $connection->prepare($query);
         $result ->execute();   
         break;
      
      case 2:
         $query = "UPDATE product SET status = '$status' WHERE id = '$id'";
         $result = $connection -> prepare($query);
         $result -> execute();
         $data=$result->fetchAll(PDO::FETCH_ASSOC);
         break;  

      case 3:
         $query = "DELETE FROM product WHERE id = $id";
         $result = $connection->prepare($query);
         $result ->execute();   
         $data=$result->fetchAll(PDO::FETCH_ASSOC);
         break;

      case 4:
         $query = "SELECT p.id, p.name, w.name AS warehouse, p.quantity, p.status FROM product AS p LEFT JOIN warehouse w ON p.warehouse = w.id";
         $result = $connection -> prepare($query);
         $result -> execute();
         $data=$result->fetchAll(PDO::FETCH_ASSOC);
         break;
      case 5:
         $query = "SELECT w.id, w.name FROM warehouse AS w";
         $result = $connection -> prepare($query);
         $result -> execute();
         $data=$result->fetchAll(PDO::FETCH_ASSOC);
         break;
      case 6:
         $query = "SELECT s.value, s.description FROM status AS s";
         $result = $connection -> prepare($query);
         $result -> execute();
         $data=$result->fetchAll(PDO::FETCH_ASSOC);
         break;
   }

   print json_encode($data, JSON_UNESCAPED_UNICODE);
   $connection = NULL;
?>