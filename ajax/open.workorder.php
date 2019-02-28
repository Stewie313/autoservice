<?
include "../include/config.php";
include "../include/mysql.php";

$data = array();
parse_str($_POST['data'], $data);

  $q="INSERT INTO `workorder` (`id`, `Cars_id`, `Masters_id`, `Description`, `human_hour`, `date_start`, `date_end`) VALUES (NULL, '".$data["Cars_id"]."', '".$data["Masters_id"]."', '".$data["Description"]."', NULL, '".$data["date_start"]."', NULL);";
  if(mysqli_query($link,$q)) 	exit("Заказ-наряд успешно открыт!");
	else 	exit("При открытии заказ-наряда произошла ошибка!");
