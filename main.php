<?php
    echo 'Hello world!';

    require "instagram.php";


	$anchor = $_GET["anchor"];
	$insta = new Instagram($anchor);
	echo json_encode($insta->urls, JSON_PRETTY_PRINT);

?>