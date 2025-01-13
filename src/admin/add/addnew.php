<?php
include_once "../../utils/helpers.php";
include_once "../../connect.php";

$table = getFromPostOrThrowError('table');   // Table name as a string
$values = getFromPostOrThrowError('values'); // Expecting an array of values
$names = getFromPostOrThrowError('names');   // Expecting an array of column names

$pdo = pdoconnect::getInstance();

var_dump($names);
// Validate table name and column names to prevent SQL injection
$table = preg_replace('/[^a-zA-Z0-9_]/', '', $table); // Allow only alphanumeric and underscores
$names = array_map(fn($name) => preg_replace('/[^a-zA-Z0-9_]/', '', $name), $names);

// Dynamically construct the query
$columns = implode(', ', $names);              // Comma-separated column names
$placeholders = implode(', ', array_fill(0, count($names), '?')); // Generate placeholders for values

$query = "INSERT INTO `$table` ($columns) VALUES ($placeholders)";
$stmt = $pdo->prepare($query);

// Bind values dynamically
$stmt->execute($values);

