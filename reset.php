<?php
require_once __DIR__ . '/../conn.php';
$sql = "truncate table results";
$result = $mysqli->query($sql);