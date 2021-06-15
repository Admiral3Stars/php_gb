<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$hello = 'Hello!';
for($i = 0; $i <= 3; $i++)
{
	echo $hello[$i];
}
echo $hello[strlen($hello)-1];