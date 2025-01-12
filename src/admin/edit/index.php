<?php
include_once '../../connect.php';
include_once '../../utils/helpers.php';

$pdo = pdoconnect::getInstance();


$id = getFromPostOrThrowError('id');
$table = getFromPostOrThrowError('table');
$values = getFromPostOrThrowError('values');
$names = getFromPostOrThrowError('names');


$set = "";

$sql = "UPDATE $table $set WHERE id = $id";
