<?php
require_once dirname(__DIR__, 1) . "/src/init.php";
require_once dirname(__DIR__, 1) . "/src/CLI/ArgParse.php";

use \Core\Auth;

$zorunluKeyler = ["uid", "exp"];
$args = argHallet($argv, $zorunluKeyler);

$uid = trim($args["uid"]);
$exp = trim($args["exp"]);

echo Auth::generateToken($uid, strtotime($exp));