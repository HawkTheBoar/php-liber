<?php
class Table{
    private static $pdo;
    private $tableName;
    private $columns;
    public function __construct($tableName){
        self::$pdo = pdoconnect::getInstance();
        $this->tableName = $tableName;
        $this->columns = $this->fetchColumns();
    }
    private function fetchColumns($sanitize = true){
        $ignore = ['created_at', 'updated_at'];
        $sql = "SHOW COLUMNS FROM $this->tableName";
        $res = self::$pdo->query($sql);
        $queryRes = $res->fetchAll();
        $columns = [];
        for($i = 0; $i < count($queryRes); $i++){
            $column = new Column($queryRes[$i]['Field'], $queryRes[$i]['Type'], $queryRes[$i]['Null'] === 'YES');
            if(!$sanitize){ }
            else if(in_array($column->getName(), $ignore)){
               continue; 
            }
            if($column->getName() === 'id')
                continue;
            // skip password anyway
            if(str_contains($column->getName(),'password')){
                continue;
            }
            array_push($columns, $column);
        }
        return $columns;
    }
    /**
     * Summary of getColumns
     * @return Column[]
     */
    public function getColumns(): array {
        // arr of cols -> arr of attributes -> Field = name, Type = type
        return $this->columns;
    }
    public function getName(): string{
        return $this->tableName;
    }
    static function getTableNameFromQuery($table){
        return reset($table);
    }
    public static function getTablesFromQuery($queryRes): array{
        
        $tables = [];
        for($i = 0; $i < count($queryRes); $i++){
            $tableName = self::getTableNameFromQuery($queryRes[$i]);
            $table = new Table($tableName);
            array_push($tables, $table);
        }
        return $tables;
    }
}