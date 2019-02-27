<?php
header ("Content-Type: text/html; charset=utf-8");

include "include/config.php";
include "include/mysql.php";


if(isset($_GET["edit"])){
	$q=mysqli_query($link,"SELECT * FROM `cars` WHERE `id`=".$_GET["edit"]);
	$a=mysqli_fetch_array($q);
	$id=$a["id"];
	$name=$a["Name"];
	$color=$a["Color"];
	$VIN=$a["VIN"];
	$client=$a["clients_id"];
} else $id=-1;
include "include/header.php";
?>

<body>

<header>
	<?php include "include/nav.php"; ?>
</header>
<section id="content">
<article>
<?
if($_POST["id"]>0)
{
	$q="UPDATE `cars` SET `Name` = '".$_POST["name"]."', `Color` = '".$_POST["color"]."', `VIN` = '".$_POST["VIN"]."', `clients_id` = '".$_POST["client"]."' WHERE `id` = ".$_POST["id"].";";
	if(mysqli_query($link,$q)) {
		$title="Успех!";
		$status="Данные машины успешно обновлены!";
	}
	else {
		$title="Ошибка!";
		$status="При обновлении данных машины произолша ошибка!";
	}
	$opendiag=true;
}
else if(strlen($_POST["name"])>2)
{
	if(!isset($_POST["client"])){
		$title="Не выбран владелец машины!";
		$status="Пожалуйста выберите владельца машины и попробуйте еще раз!";
	} else if(strlen($_POST["VIN"])!=17) {
		$title="Не правильный VIN!";
		$status="VIN - уникальный код транспортного средства, состоящий из 17 знаков.!";
	} else if(strlen($_POST["color"])<2) {
		$title="Не указан цвет машины!";
		$status="Пожалуйста укажите цвет машины и попробуйте еще раз!!";
	}	else {
		$query="INSERT INTO `cars` (`id`, `Name`, `Color`, `VIN`, `clients_id`) VALUES (NULL, '".$_POST["name"]."', '".$_POST["color"]."', '".$_POST["VIN"]."', '".$_POST["client"]."');";
		if(mysqli_query($link,$query)) {
			$title="Успех!";
			$status="Машина успешно добавлена!";
		}
		else {
			$title="Ошибка!";
			$status="При добавление машины произошла ошибка!";
		}
	}
	$opendiag=true;
}
else if(isset($_GET["delete"]))
{
	$query="DELETE FROM `cars` WHERE `id`=".$_GET["delete"].";";
	if(mysqli_query($link,$query)) {
		$title="Успех!";
		$status="Машина успешно удалена!";
	}
	else {
		$title="Ошибка!";
		$status="При удалении машины произошла ошибка!";
	}
	$opendiag=true;
}
?>

<form name="new_client" method="post" action="cars.php">
	<? if(!isset($_GET["edit"])) {?>
  <h2 class="pad">Добавление нового автомобиля:</h2>
<? } else {?>
	<h2 class="pad">Редактирование автомобиля:</h2>
	<? }?>
  <input name="id" type="hidden" size="8" value="<?=$id?>">
  <p><b>Модель:</b><input class="ui-spinner-input" name="name" type="text" size="40" value="<?=$name?>"></p>
  <p><b>Цвет:</b><input class="ui-spinner-input" name="color" type="text" size="40" value="<?=$color?>"></p>
  <p><b>VIN:</b><input class="ui-spinner-input" name="VIN" type="text" size="40" value="<?=$VIN?>"></p>
	<p><b>Владелец:</b>
    <select name="client" id="salutation">
      <option disabled selected>Выберите одного:</option>
			<?
	 			$q="SELECT * FROM `clients`"; // Начальный запрос
				$q=mysqli_query($link,$q);
				while($a=mysqli_fetch_array($q))
				{
					if($client==$a["id"])
						echo "<option selected=\"selected\" value=\"".$a["id"]."\">".$a["Name"]."</option>";
					else
						echo "<option value=\"".$a["id"]."\">".$a["Name"]."</option>";
				}

			 ?>
  	</select></p>
  <p><input class="ui-button ui-widget ui-corner-all"   type="submit" value="<? if(isset($_GET["edit"])) echo "Обновить"; else echo "Добавить";?>">
  <? if(!isset($_GET["edit"])) {?><input class="ui-button ui-widget ui-corner-all"  type="reset" value="Очистить"><? } ?></p>
 </form>
 <? if(isset($_GET["edit"]))exit("<p><a class=\"ui-button ui-widget ui-corner-al\"   href=\"/cars.php\">Вернуться назад</a></p></body></html>"); ?>
 <table class="heavyTable" class="price-table" border="1">
   <caption>Все машины <br></caption>
   <tr class="price-column">
    <th><a href="#">Модель</a></th>
    <th><a href="#">Цвет</a></th>
	  <th><a href="#">VIN</a></th>
	  <th><a href="#">Владелец</a></th>
   </tr>
   <?
	 $q="SELECT COUNT(*) as `c` FROM `cars`";
	 $q=mysqli_query($link,$q);
	 $q=mysqli_fetch_array($q);
	 $c=$q["c"];

	 $page = $_GET["page"] ?? 1;
	 $start = ($page-1)*PAGE_MAX;
	 $pages= intval($c/PAGE_MAX);
	 if($pages*PAGE_MAX < $c) $pages++;

	 $q="SELECT `cars`.*, `clients`.`Name` as `ClientName` FROM `cars` JOIN `clients` WHERE `clients`.`id`=`clients_id`";
	 $q.=" LIMIT $start, ".PAGE_MAX;

		$q=mysqli_query($link,$q);
		$empty=true;
		while($a=mysqli_fetch_array($q))
		{
			$empty=false;
			echo "<tr><td><a href=\"/cars.php?edit=".$a['id']."\" title=\"Изменить\">".$a['Name']." &#9998;</a>  <a href=\"/cars.php?delete=".$a['id']."\" title=\"Удалить\"> &#10008;</a></td>";
			echo "<td>".$a['Color']."</td>";
			echo "<td>".$a['VIN']."</td>";
			echo "<td>".$a['ClientName']."</td></td>";
		}
		if($empty) echo '<tr><td colspan="4"><h2>Записей нет.</h2></td></tr>';
		else {
			echo '<tr><td class="paginator" colspan="4">';
				for($i=1;$i<=$pages;$i++) {
					if($i!=$page)
						echo '<a href="/cars.php?page='.$i.'"> '.$i.' </a>';
					else
						echo '<b> '.$i.' </b>';
				}
			echo '</td></tr>';
		}

   ?>
   </table>
</section>
<div id="dialog" title="<?=$title;?>">
	<p>
		<?=$status;?>
	</p>
</div>
<script>
$(document).ready(function() {
<? if($opendiag){ ?>
$( "#dialog" ).dialog( "open" );
<? } ?>
});
</script>
<?php include "include/footer.php"; ?>
