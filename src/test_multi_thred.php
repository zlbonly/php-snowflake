<?php


require "idwork.php";


$node_id = rand(1, 1023);
$sequnce = rand(1, 4095);

$obj = IdWork::getInstance()->setWorkId($node_id, $sequnce);

$child_pids = [];

//开启多进程
for ($i = 0; $i < 15; $i++) {
    $pid = pcntl_fork();
    if ($pid == -1) {
        exit("fork fail");
    } elseif ($pid) {

        $child_pids[] = $pid;
        $id = getmypid();
    } else {
        $id = getmypid();

        $id = $obj->nextId();
        echo $id . PHP_EOL;
        exit();
    }
}


while (count($child_pids)) {
    foreach ($child_pids as $key => $pid) {
        $res = pcntl_waitpid($pid, $satus, WNOHANG);
        if ($res == -1 || $res == 0) {
            unset($child_pids[$key]);
        }
    }
}