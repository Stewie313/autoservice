<?
include "../include/config.php";
include "../include/mysql.php";

	$q="DELETE FROM `priceforworkorder` WHERE `id`=".$_GET["id"].";";
	if(mysqli_query($link,$q)) 	exit("Работа успешно удалена!");
	else 	exit("При удалении произошла ошибка!");
