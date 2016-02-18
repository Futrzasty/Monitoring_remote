<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link href="index.css" rel="stylesheet" type="text/css" />
    <title>IT Monitoring System</title>
</head>
<body>

<?php
    error_reporting(E_ALL & ~E_NOTICE);
    include_once ("functions.php");

    $server = new mysqli('localhost', $db_user, $db_pass, $db_name);
    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }

    $server->query("SET CHARACTER SET utf8");
    $server->query("SET NAMES utf8");
    $server->query("SET COLLATION utf8");


    $result = $server->query("SELECT * FROM hosts WHERE rrd_file IS NOT NULL ORDER BY `order`");
    while($row = $result->fetch_assoc()) {
        $rrd_file = $row["rrd_file"];
        $rrd_parm = $row["type"];
        if ($row["type"] == 'ping') {
            $rrd_desc = "Ping (ms)";
        } else {
            $rrd_desc = 'Parametr';
        }
        echo "<img src='rrd_graph.php?$rrd_file;$rrd_parm;$rrd_desc;now-24h' /><br />";
        echo "<img src='rrd_graph.php?$rrd_file;$rrd_parm;$rrd_desc;now-30d' /><br />";
    }

    echo "<img src='rrd_graph.php?extime.rrd;extime;Czas wykonywania (s);now-30d' /><br />";