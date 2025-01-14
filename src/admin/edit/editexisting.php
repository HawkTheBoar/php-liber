<?php
include_once "../../utils/helpers.php";
include_once "../../connect.php";

$table = getFromPostOrThrowError('table');   // Table name as a string
$values = getFromPostOrThrowError('values'); // Expecting an array of values
$names = getFromPostOrThrowError('names');   // Expecting an array of column names
$id = getFromPostOrThrowError('id');

$pdo = pdoconnect::getInstance();

var_dump($names);
// Validate table name and column names to prevent SQL injection
$table = preg_replace('/[^a-zA-Z0-9_]/', '', $table); // Allow only alphanumeric and underscores
$names = array_map(fn($name) => preg_replace('/[^a-zA-Z0-9_]/', '', $name), $names);
$set = "";
// Dynamically construct the query
for($i = 0; $i < count($names); $i++){
    $set += "$names[$i] = ?, ";
}
echo $set;
$set = substr($set, strlen($names[$i])-3);
echo $set;
$query = "UPDATE `$table` SET $set WHERE id = :id";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $id);
// Bind values dynamically
$stmt->execute($values);

