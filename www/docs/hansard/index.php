<?php

include_once '../../includes/easyparliament/init.php';

$url = "/";

if (($date = get_http_var('d')) && preg_match('#^\d\d\d\d-\d\d-\d\d$#', $date)) {
    $url .= "calendar/$date";
}

header("Location: $url");
