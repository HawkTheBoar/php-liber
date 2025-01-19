<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/middleware/protect_route.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/connect.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/types/admin/table.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/types/admin/column.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/components/navbar.php";
    
    try {
        $pdo = pdoconnect::getInstance();
        
    } catch (PDOException $e) {
    }

    $sql = "SHOW TABLES";
    $query = $pdo->query($sql);
    $queryRes = $query->fetchAll();
    
    $tables = Table::getTablesFromQuery($queryRes);
    
?>
<!DOCTYPE html>
<html lang="en">
    <?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . "/components/head.php"
    ?>
<body>
    <?php
        Navbar::render_admin();
    ?>
    <div>
        <h1 class="text-2xl font-bold">Admin Panel</h1>
        <div class="">
            <?php
                foreach($tables as $table){
                
            ?>

            <div>
                <div>
                    <h1><?php echo $table->getName() ?></h1>
                    <a class="" href="/admin/add/<?php echo $table->getName() ?>.php">Přidat</a>
                </div>
                <table class="w-[80%] text-center ">
                    <tr>
                        <?php
                            foreach($table->getColumns() as $column){
                        ?>
                        <th class="odd:bg-green-700 bg-green-600"><?php echo $column->getName() ?></th>
                        <?php
                            }
                        ?>
                        <th class="odd:bg-green-700 bg-green-600">Actions</th>
                    </tr>
                    <?php
                        $sql = "SELECT * FROM " . $table->getName() . " LIMIT 10";
                        $query = $pdo->query($sql);
                        $queryRes = $query->fetchAll();
                        foreach($queryRes as $row){
                    ?>
                    <tr class="bg-neutral-200 odd:bg-white py-4">
                        <?php
                            foreach($table->getColumns() as $column){
                        ?>
                        <td><?php echo $row[$column->getName()] ?></td>
                        <?php
                            }
                        ?>
                        <td>
                            <a class="bg-blue-600 rounded mr-4" href="/admin/edit/<?php echo $table->getName() ?>.php?id=<?php echo $row['id'] ?>">
                            Edit
                            </a>
                            <a class="bg-red-600 rounded "  href="/admin/delete/<?php echo $table->getName() ?>.php?id=<?php echo $row['id'] ?>">
                                Delete
                            </a>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                </table>
            </Di>
            <?php
                }
            ?>
        </div>
    </div>
</body>
</html>

