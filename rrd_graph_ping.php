<?php
    include_once ("functions.php");

    # Wykres PING HARDCODED
    $fid = uniqid('rrd_', true);
    $file = "/tmp/$fid";

    $opt_default = array( "--end", "now", "--start=end-4h", "--width=1000", "--height=200", "--full-size-mode", "--border=0", "--color=BACK#444444", "--color=CANVAS#444444", "--color=FONT#cccccc", "--color=ARROW#222222",
        "DEF:ping=$webserver_path/remote/rrd_data/ping_kociak3.rrd:ping:AVERAGE",
        "LINE1:ping#ff0000:Ping Time (ms) ",
    );

    $opcja = $opt_default;

    $ret = rrd_graph($file, $opcja);

    header("Content-Type: image/png");
    header("Content-Length: ".filesize($file));

    $hand = fopen($file, "rb");
    if ($hand) {
        fpassthru($hand);
        fclose($hand);
    }
    system("rm -f $file");