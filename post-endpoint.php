<?php
require('autoloader.php');

use classes\Connection;

$db = new Connection();
$db->storeEntry(json_decode($_POST['user']), json_decode($_POST['events']), json_decode($_POST['keyboard']));