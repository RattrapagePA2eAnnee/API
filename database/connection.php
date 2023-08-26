<?php

function getDatabaseConnection(): PDO
{
    require __DIR__ . "/settings.php";

    try {
        $pdo = new PDO("$databaseDialect:host=$databaseHostname;dbname=$databaseName", $databaseUsername, $databasePassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }

    return $pdo;
}

