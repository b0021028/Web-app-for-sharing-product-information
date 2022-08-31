<?php
    header("HTTP/1.0 404 Not Found");
    print file_get_contents(__DIR__."/404.html");
    exit;
?>