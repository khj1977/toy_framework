<?php
   $pdo = new PDO("mysql:dbname=" . "foo" . ";host=" . "127.0.0.1", "", "");
   $statement = $pdo->prepare("SELECT * FROM bar");
   $statement->execute(array());
   while($rows = $statement->fetch()) {
    printf("line break¥n");
    var_dump($rows);
   }

?>