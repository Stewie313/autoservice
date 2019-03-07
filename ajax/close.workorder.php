<?
include "../include/config.php";
include "../include/mysql.php";

$data = array();
parse_str($_POST['data'], $data);

  $q="UPDATE `workorder` SET `human_hour` = '".$data["human_hour"]."', `date_end` = '".$data["date_end"]."' WHERE `workorder`.`id` = ".$data["id"].";";
  if(mysqli_query($link,$q)) 	exit("Заказ-наряд успешно закрыт!");
	else 	exit("При закрытии заказ-наряда произошла ошибка!");
