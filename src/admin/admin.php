<?php
    include_once "../connect.php";
    include_once "../types/admin/table.php";
    include_once "../types/admin/column.php";
    
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
    include_once "../components/head.php"
    ?>
<body>
    <div>
        <h1>Admin Panel</h1>
        <div class="">
            <?php
                foreach($tables as $table){
                
            ?>

            <div>
                <div>
                    <h1><?php echo $table->getName() ?></h1>
                    <a href="/admin/add/<?php echo $table->getName() ?>.php">Přidat</a>
                </div>
                <table>
                    <?php
                        foreach($table->getColumns() as $column){
                    ?>
                    <th><?php echo $column->getName() ?></th>
                    <?php
                        }
                    ?>
                    <th>Actions</th>
                    <?php
                        $sql = "SELECT * FROM " . $table->getName() . " LIMIT 10";
                        $query = $pdo->query($sql);
                        $queryRes = $query->fetchAll();
                        foreach($queryRes as $row){
                    ?>
                    <tr>
                        <?php
                            foreach($table->getColumns() as $column){
                        ?>
                        <td><?php echo $row[$column->getName()] ?></td>
                        <?php
                            }
                        ?>
                        <td>
                            <a href="/admin/edit/<?php echo $table->getName() ?>.php?id=<?php echo $row['id'] ?>">
                            Edit
                            </a>
                            <a href="/admin/delete/<?php echo $table->getName() ?>.php?id=<?php echo $row['id'] ?>">
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

