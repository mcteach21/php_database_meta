<?php
/**
 * mc@2021
 */
const DSN='mysql:host=localhost;dbname=world;charset=utf8mb4;port=3306';
const USERNAME='root';
const PASSWORD='';
const OPTIONS=[
    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    \PDO::ATTR_EMULATE_PREPARES   => false,
];

const SCHEMA_NAME='world';