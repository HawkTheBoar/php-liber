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
                <form action="/admin/add/addnew.php" method="POST">
                    <h1><?php echo $table->getName() ?></h1>
                    
                    <input type="hidden" style="display: none" name="table" value="<?php echo $table->getName() ?>">
                    <?php
                        foreach($table->getColumns() as $column){
                    ?>
                    <input type="hidden" name="names[]" value="<?php echo $column->getName() ?>">
                    <input type="text" name="values[]" placeholder="<?php echo $column->getName() ?>">
                    <?php
                        }
                    ?>
                    <button type="submit">Přidat</button>
                </form>
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
                    </tr>
                    <?php
                        }
                    ?>
                </table>
            </div>
            <?php
                }
            ?>
        </div>
    </div>
</body>
</html>

