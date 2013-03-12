<?php
require_once('delicious.php');

$deli = new delicious(USERNAME, PASSWORD);
$x = $deli->get_all();

//$deli->add('http://google.com', 'searchengine', 'search,super');
//$g = $deli->get('browserdiet.com');
//print_r($g);
//$x = $deli->get_all();
//$x = $deli->get_by_tag('mysql');
//$x = $deli->get_by_offset(1, 5);
//$x = $deli->get_by_date_range('2013-03-05', '2013-03-15');
//$deli->add('http://google.com/', 'code breaker', 'search');
//$deli->delete('http://animestash.info/anime/show/4306');
//$x = $deli->get_recent('php', 17);
//$x = $deli->hashes();
//$x = $deli->suggest('http://php.net/manual/en/function.date.php');
//$x = $deli->tags();
?>
<hr>
