<?php
require('autoloader.php');

use classes\Connection;

$db = new Connection();

$db->storeEntry(1, json_decode($_POST['data']), 1);