<?php
include_once "../../utils/helpers.php";
include_once "../../connect.php";
$config = loadJson("../config.json");
$addPath = "/admin/add/products.php";
$siteName = 'products';

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    try{
        // gather values from post
        $values = [];
        foreach($config[$siteName]['fields'] as $field){
            $value = null;
            try{
               $value = getFromPostOrThrowError($field['name']); 
            }
            catch(Error $e){
                if($field['required'])
                {
                    $fieldName = $field['name'];
                    header("$addPath?error=$fieldName+was+not+provided.");
                }
            }
            array_push($values, $value);
            
        }
        
        $pdo = pdoconnect::getInstance();
        
        // Extract column names from config
        $names = array_map(function ($i) { return $i['name']; }, $config[$siteName]['fields']);   
        
        // Dynamically construct the query
        $columns = implode(', ', $names); // Comma-separated column names
        $placeholders = implode(', ', array_fill(0, count($values), '?')); // Generate placeholders for values
        
        $tableName = $config[$siteName]['name'];
        $query = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";
        $stmt = $pdo->prepare($query);
        
        // Bind values dynamically
        $stmt->execute($values);
        header("$addPath?success=Item+was+added+to+database!");
    } catch(Error $e) {
        header("$addPath?error=An+error+occured.");
    }
}
else{
    include_once "../../types/admin/table.php";

    $pdo = pdoconnect::getInstance();
    $fields = $config[$siteName]['fields'];
    echo "<form action='$addPath' method='POST'>";
    foreach($fields as $field){
        echo "<div>";
        if($field['required']){
            echo "<span style='color:red'>*</span>";
        }
        switch($field['type']){
            case 'relation':
                $sql = "SELECT name, id FROM " . $field['relation'];
                $query = $pdo->query($sql);
                $queryRes = $query->fetchAll();
                ?>
                    
                        <label for="<?php echo $field['name'] ?>"><?php echo $field['relation'] ?></label>
                        <select <?php if($field['required']) echo "required" ?> name="<?php echo $field['name'] ?>">
                            <?php
                                foreach($queryRes as $row){
                            ?>
                                <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                            <?php
                                }
                            ?>
                        </select>
                <?php
                break;
            case 'enum':
                ?>
                    <label for="<?php echo $field['name'] ?>"><?php echo $field['name'] ?></label>
                    <select <?php if($field['required']) echo "required" ?> name="<?php echo $field['name'] ?>">
                        <?php
                            foreach($field['values'] as $value){
                        ?>
                            <option value="<?php echo $value ?>"><?php echo $value ?></option>
                        <?php
                            }
                        ?>
                    </select>
                <?php
                break;
            default:
                ?>
                    <label for="<?php echo $field['name'] ?>"><?php echo $field['name'] ?></label>
                    <input <?php if($field['required']) echo "required" ?> type="<?php echo $field['type'] ?>" name="<?php echo $field['name'] ?>" placeholder="<?php echo $field['name'] ?>">
                <?php
                break;
        }
       
        echo "</div>";
        
    }
    echo "<button type='submit'>Add</button>";
    echo "</form>";
}