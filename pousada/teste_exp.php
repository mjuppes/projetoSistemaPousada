<?php
session_cache_expire(1);
$cache_expire = session_cache_expire();

session_start();

echo $cache_expire;
return;

?>