<?
include "../include/config.php";
include "../include/mysql.php";

$data = array();
parse_str($_POST['data'], $data);
$q="SELECT * FROM `price` WHERE `id`=".$data["Price_id"];
$q=mysqli_query($link,$q);
$a=mysqli_fetch_array($q);
$q="INSERT INTO `priceforworkorder` (`id`, `Price_id`, `WorkOrder_id`, `ammount`, `total_cost`) VALUES (NULL, '".$data["Price_id"]."', '".$data["WorkOrder_id"]."', '".$data["ammount"]."', '".($data["ammount"]*$a["Price"])."')";
if(mysqli_query($link,$q)) 	exit("Работа добавлена!");
else 	exit("Произошла ошибка!");
