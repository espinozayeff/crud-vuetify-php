<?php
   class Connection {
      public static function Connect() {
         define('server', 'localhost');
         define('dbname', 'vuetify');
         define('user', 'root');
         define('password', '');

         $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

         try {
            $connection = new PDO("mysql:host=".server."; dbname=" .dbname, user, password, $options);
            return $connection;
         } catch (Exception $e) {
            die("Ha ocurrido un error en la conexión a la base de datos: " . $e->getMessage());
         }
      }
   }
?>