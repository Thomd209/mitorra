<?php

$user = 'admin';
$pass = '12345';

$pdo = new PDO('mysql:host=localhost;dbname=test', $user, $pass);

$handle = fopen('shop.csv', 'r');
for ($i = 0; $row = fgetcsv($handle); $i++) {

    $name = $row['name'];
    $amount = $row['amount'];
    $price = $row['price']

    $sql = "INSERT INTO product (name, amount, price) VALUES (?,?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $amount, $price]);
}

fclose($handle);