<?php
    $dsn = 'mysql:host=localhost; dbname=GroceryStore';
    $username = 'root';
    $password = '';

    try{
        $db = new PDO($dsn, $username, $password);
    }
    catch(PDOException $e){
        $error = $e->getMessage();
?>
    <p>Unable to connect to database</p>
    <p><?php echo $error;?></p>

<?php
        exit();
    }
?>