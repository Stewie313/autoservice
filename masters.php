<?php
header ("Content-Type: text/html; charset=utf-8");

include "include/config.php";
include "include/mysql.php";


if(isset($_GET["edit"])){
	$q=mysqli_query($link,"SELECT * FROM `masters` WHERE `id`=".$_GET["edit"]);
	$a=mysqli_fetch_array($q);
	$id=$a["id"];
	$Name=$a["Name"];
	$Adress=$a["Adress"];
	$Phone=$a["Phone"];
	$Specialization=$a["Specialization_id"];
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
	$query="UPDATE `masters` SET `Name` = '".$_POST["name"]."', `Adress` = '".$_POST["adress"]."', `Phone` = '".$_POST["phone"]."', `Specialization_id` = '".$_POST["Specialization_id"]."' WHERE `masters`.`id` = ".$_POST["id"].";";
	if(mysqli_query($link,$query)) {
		$title="Успех!";
		$status="Данные мастера успешно обновлены!";
	}
	else {
		$title="Ошибка!";
		$status="При обновлении данных мастера произолша ошибка!";
	}
	$opendiag=true;
}
else if(strlen($_POST["name"])>2)
{
	if(!isset($_POST["Specialization_id"])){
		$title="Не выбрана должности!";
		$status="Пожалуйста выберите должность и попробуйте еще раз!";
	} else if(strlen($_POST["adress"])<10) {
		$title="Ошибка!";
		$status="Адресс не может быть таким коротким!";
	} else if(strlen($_POST["phone"])<9) {
		$title="Ошибка!";
		$status="Не заполнен телефонный номер! Телефонный номер содержит 10 символов и состоит из кода страны, кода города и номера абонента!";
	}	else {
	$query="INSERT INTO `masters` (`id`, `Name`, `Adress`, `Phone`, `Specialization_id`) VALUES (NULL, '".$_POST["name"]."', '".$_POST["adress"]."', '".$_POST["phone"]."', '".$_POST["Specialization_id"]."');";
	if(mysqli_query($link,$query)) {
		$title="Успех!";
		$status="Мастер успешно добавлен!";
	}
	else {
		$title="Ошибка!";
		$status="При добавлении мастера произошла ошибка! $query";
	}}
	$opendiag=true;
}
else if(isset($_GET["delete"]))
{
	$query="DELETE FROM `masters` WHERE `id`=".$_GET["delete"].";";
	if(mysqli_query($link,$query)) {
		$title="Успех!";
		$status="мастер успешно удален!";
	}
	else {
		$title="Ошибка!";
		$status="При удалении мастера произошла ошибка!";
	}
	$opendiag=true;
}
?>

<form name="new_client" method="post" action="masters.php">
	<? if(!isset($_GET["edit"])) {?>
  <h2 class="pad">Добавление нового мастера:</h2>
<? } else {?>
	<h2 class="pad">Редактирование мастера:</h2>
	<? }?>
  <input name="id" type="hidden" size="8" value="<?=$id?>">
  <p><b>Имя:</b><input class="ui-spinner-input" name="name" type="text" size="40" value="<?=$Name?>"></p>
  <p><b>Адрес:</b><input class="ui-spinner-input" name="adress" type="text" size="40" value="<?=$Adress?>"></p>
  <p><b>Телефон:</b><input class="ui-spinner-input" name="phone" type="text" size="40" value="<?=$Phone?>"></p>
	<p><b>Должность:</b>
    <select name="Specialization_id" id="salutation">
      <option disabled selected>Выберите:</option>
			<?
	 			$q="SELECT * FROM `Specialization`";
				$q=mysqli_query($link,$q);
				while($a=mysqli_fetch_array($q))
				{
					if($Specialization==$a["id"])
						echo "<option selected=\"selected\" value=\"".$a["id"]."\">".$a["Name"]." (".$a["hour_salary"].")</option>";
					else
						echo "<option value=\"".$a["id"]."\">".$a["Name"]." (".$a["hour_salary"].")</option>";
				}

			 ?>
  	</select></p>
  <p><input class="ui-button ui-widget ui-corner-all"   type="submit" value="<? if(isset($_GET["edit"])) echo "Обновить"; else echo "Добавить";?>">
  <? if(!isset($_GET["edit"])) {?><input class="ui-button ui-widget ui-corner-all"  type="reset" value="Очистить"><? } ?></p>
 </form>
 <? if(isset($_GET["edit"]))exit("<p><a class=\"ui-button ui-widget ui-corner-al\"   href=\"/masters.php\">Вернуться назад</a></p></body></html>"); ?>


 <table class="heavyTable" class="price-table" border="1">
   <caption>Все мастера <br></caption>
   <tr class="price-column">
    <th><a href="<?if($_GET["sort_id"]=="ASK") echo "/masters.php?sort_id=DESC\">&uarr;"; else echo "/masters.php?sort_id=ASK\" title=\"Отсортировать\">&darr;";?> ID &#9745;</a></th>
    <th><a href="<?if($_GET["sort_name"]=="ASK") echo "/masters.php?sort_name=DESC\">&uarr;"; else echo "/masters.php?sort_name=ASK\" title=\"Отсортировать\">&darr;";?> Имя &#9787;</a></th>
    <th><a href="<?if($_GET["sort_adress"]=="ASK")echo "/masters.php?sort_adress=DESC\">&uarr;"; else echo "/masters.php?sort_adress=ASK\" title=\"Отсортировать\">&darr;";?> Адрес &#9872;</a></th>
    <th><a href="<?if($_GET["sort_phone"]=="ASK")echo "/masters.php?sort_phone=DESC\">&uarr;"; else echo "/masters.php?sort_phone=ASK\" title=\"Отсортировать\">&darr;";?> Телефон &#9742;</a></th>
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

		$q="SELECT * FROM `masters`"; // Начальный запрос
		$q.=" LIMIT $start, ".PAGE_MAX;

		/************** Добавление сортировки *************/
		if($_GET["sort_id"]=="ASK") $q.=" ORDER BY `id`";
		else if($_GET["sort_id"]=="DESC") $q.=" ORDER BY `id` DESC";
		else if($_GET["sort_name"]=="ASK") $q.=" ORDER BY `Name`";
		else if($_GET["sort_name"]=="DESC") $q.=" ORDER BY `Name` DESC";
		else if($_GET["sort_adress"]=="ASK") $q.=" ORDER BY `Adress`";
		else if($_GET["sort_adress"]=="DESC") $q.=" ORDER BY `Adress` DESC";
		else if($_GET["sort_phone"]=="ASK") $q.=" ORDER BY `Phone`";
		else if($_GET["sort_phone"]=="DESC") $q.=" ORDER BY `Phone` DESC";

		$q=mysqli_query($link,$q);
		$empty=true;
		while($a=mysqli_fetch_array($q))
		{
			$empty=false;
			echo "<tr><td><a href=\"/masters.php?edit=".$a['id']."\" title=\"Изменить\">".$a['id']." &#9998;</a>  <a href=\"/masters.php?delete=".$a['id']."\" title=\"Удалить\"> &#10008;</a></td>";
			echo "<td>".$a['Name']."</td>";
			echo "<td>".$a['Adress']."</td>";
			echo "<td><a class=\"link\" href=\"tel:".$a['Phone']."\">".$a['Phone']."</a></td></tr>";
		}
		if($empty) echo '<tr><td colspan="4"><h2>Записей нет.</h2></td></tr>';
		else {
			echo '<tr><td class="paginator" colspan="4">';
				for($i=1;$i<=$pages;$i++) {
					if($i!=$page)
						echo '<a href="/clitnts.php?page='.$i.'"> '.$i.' </a>';
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
