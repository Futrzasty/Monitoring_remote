<?php
	include_once ("functions.php");

	# Wykres Execution time
	$fid = uniqid('rrd_', true);
	$file = "/tmp/$fid";

	$opt_default = array( "--end", "now", "--start=end-4h", "--width=1000", "--height=200", "--full-size-mode", "--border=0", "--color=BACK#444444", "--color=CANVAS#444444", "--color=FONT#cccccc", "--color=ARROW#222222",
					"DEF:extime=$webserver_path/remote/rrd_data/extime.rrd:extime:AVERAGE",
					"LINE1:extime#ff0000:Execution Time (s) ",
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

	# Wykres PING HARDCODED
	$fid = uniqid('rrd_', true);
	$file = "/tmp/$fid";

	$opt_default = array( "--end", "now", "--start=end-4h", "--width=1000", "--height=200", "--full-size-mode", "--border=0", "--color=BACK#444444", "--color=CANVAS#444444", "--color=FONT#cccccc", "--color=ARROW#222222",
		"DEF:extime=$webserver_path/remote/rrd_data/ping_kociak3.rrd:ping:AVERAGE",
		"LINE1:extime#ff0000:Execution Time (s) ",
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
