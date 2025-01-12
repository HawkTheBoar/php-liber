<?php
    include_once "../connect.php";
    try {
        $pdo = pdoconnect::getInstance();
        
    } catch (PDOException $e) {
    }
    $sql = "SHOW TABLES";
    $res = $pdo->query($sql);
    var_dump($res->fetchAll());

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <h1>Admin Panel</h1>
        <div class="">
            <div>
                <h1>Category</h1>
                <button>Přidat </button>
            </div>
        </div>
    </div>
</body>
</html>

