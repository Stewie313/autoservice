<?
include "../include/config.php";
include "../include/mysql.php";

$data = array();
parse_str($_POST['data'], $data);
$q="SELECT * FROM `parts` WHERE `id`=".$data["Parts_id"];
$q=mysqli_query($link,$q);
$a=mysqli_fetch_array($q);
$q="INSERT INTO `partsforworkorder` (`id`, `Parts_id`, `WorkOrder_id`, `ammount`, `total_cost`) VALUES (NULL, '".$data["Parts_id"]."', '".$data["WorkOrder_id"]."', '".$data["ammount"]."', '".($data["ammount"]*$a["Price"])."')";
if(mysqli_query($link,$q)) 	exit("Запчасть добавлена!");
else 	exit("Произошла ошибка!");
