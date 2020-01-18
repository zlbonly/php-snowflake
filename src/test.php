<?php

require "idwork.php";

$node_ID = rand(1, 1023);

$i = 0;

do {
    $id = IdWork::getInstance()->setWorkId($node_ID)->nextId();
    echo $id . PHP_EOL;
    $i++;
} while ($i < 10);