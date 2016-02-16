<?php
    error_reporting(E_ALL & ~E_NOTICE);
    include_once ("functions.php");

    $time_start = microtime(true);

    $server = new mysqli('localhost', $db_user, $db_pass, $db_name);
    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }

    $server->query("SET CHARACTER SET utf8");
    $server->query("SET NAMES utf8");
    $server->query("SET COLLATION utf8");


    $result = $server->query("SELECT * FROM hosts ORDER BY `order`");
    while($row = $result->fetch_assoc()) {
        $state_old = $row["state"];
        $id = $row["id"];
        if ($row["disabled"] == 1) continue;
        switch ($row["type"]) {
            case "ping":
                $probe = check_ping($row["ip"], 200, 50, 500, 70);
                list ($state, $value, $value2) = $probe;
               if ($state != $state_old) $server->query("UPDATE hosts SET last_change= CURRENT_TIMESTAMP WHERE id = $id");
                $server->query("UPDATE hosts SET `value_last` = `value`, `value` = $value, `value2_last` = `value2`, `value2` = $value2, `state` = $state, `last_check` = CURRENT_TIMESTAMP WHERE id = $id");
                break;
            case "www":
                $comm = explode("|", $row["probe_cmd"]);
                $state = check_www($comm[0], $comm[1])[0];
                if ($state != $state_old) $server->query("UPDATE hosts SET last_change= CURRENT_TIMESTAMP WHERE id = $id");
                $server->query("UPDATE hosts SET `value_last` = `value`, `value` = $state, `state` = $state, `last_check` = CURRENT_TIMESTAMP WHERE id = $id");
                break;
            case "smtp":
                $state = nrpe_smtp($row["ip"])[0];
                if ($state != $state_old) $server->query("UPDATE hosts SET last_change= CURRENT_TIMESTAMP WHERE id = $id");
                $server->query("UPDATE hosts SET `value_last` = `value`, `value` = $state, `state` = $state, `last_check` = CURRENT_TIMESTAMP WHERE id = $id");
                break;
            case "ssh":
                $probe = check_ssh($row["ip"], $row["probe_cmd"]<>NULL?$row["probe_cmd"]:"22");
                list ($state, $value) = $probe;if ($state != $state_old) $server->query("UPDATE hosts SET last_change= CURRENT_TIMESTAMP WHERE id = $id");
                $server->query("UPDATE hosts SET `value_last` = `value`, `value` = $value, `state` = $state, `last_check` = CURRENT_TIMESTAMP WHERE id = $id");
                break;
        }
    }

    $time_end = microtime(true);
    $extime = $time_end - $time_start;
    rrd_update($webserver_path."remote/rrd_data/extime.rrd", array("N:$extime"));
    //echo date(DATE_RFC822).": Execution time ".$extime." sec.\n";