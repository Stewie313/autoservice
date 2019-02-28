<?
include "../include/config.php";
include "../include/mysql.php";

	$q="DELETE FROM `workorder` WHERE `id`=".$_GET["id"].";";
	if(mysqli_query($link,$q)) 	exit("Заказ-наряд успешно удален!");
	else 	exit("При удалении заказ-наряда произошла ошибка!");
