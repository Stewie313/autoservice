<?php
header ("Content-Type: text/html; charset=utf-8");

include "include/config.php";
include "include/mysql.php";


if(isset($_GET["edit"])){
	$q=mysqli_query($link,"SELECT * FROM `specialization` WHERE `id`=".$_GET["edit"]);
	$a=mysqli_fetch_array($q);
	$id=$a["id"];
	$name=$a["Name"];
	$HS=$a["hour_salary"];
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
	$q="UPDATE `specialization` SET `Name` = '".$_POST["name"]."', `hour_salary` = '".$_POST["hour_salary"]."' WHERE `id` = ".$_POST["id"].";";
	if(mysqli_query($link,$q)) {
		$title="Успех!";
		$status="Данные успешно обновлены!";
	}
	else {
		$title="Ошибка!";
		$status="При обновлении данных произолша ошибка!";
	}
	$opendiag=true;
}
else if(strlen($_POST["name"])>2)
{
	if($_POST["hour_salary"]<200){
		$title="Ошибка!";
		$status="Пожалуйста выставьте более достойную почасовую ставку!";
	} else {
		$query="INSERT INTO `specialization` (`id`, `Name`, `hour_salary`) VALUES (NULL, '".$_POST["name"]."', '".$_POST["hour_salary"]."');";
		if(mysqli_query($link,$query)) {
			$title="Успех!";
			$status="Должность успешно добавлена!";
		}
		else {
			$title="Ошибка!";
			$status="При добавление должности произошла ошибка!";
		}
	}
	$opendiag=true;
}
else if(isset($_GET["delete"]))
{
	$query="DELETE FROM `specialization` WHERE `id`=".$_GET["delete"].";";
	if(mysqli_query($link,$query)) {
		$title="Успех!";
		$status="Должность успешно удалена!";
	}
	else {
		$title="Ошибка!";
		$status="При удалении должности произошла ошибка!";
	}
	$opendiag=true;
}
?>

<form name="new_client" method="post" action="specialization.php">
	<? if(!isset($_GET["edit"])) {?>
  <h2 class="pad">Добавление новой должности:</h2>
<? } else {?>
	<h2 class="pad">Редактирование должности:</h2>
	<? }?>
  <input name="id" type="hidden" size="8" value="<?=$id?>">
  <p><b>Наименование:</b><input class="ui-spinner-input" name="name" type="text" size="40" value="<?=$name?>"></p>
  <p><b>Почасовая ставка:</b><input id="spinner" class="ui-spinner-input" name="hour_salary" type="text" size="40" value="<?=$HS?>"></p>
	<p><input class="ui-button ui-widget ui-corner-all"   type="submit" value="<? if(isset($_GET["edit"])) echo "Обновить"; else echo "Добавить";?>">
  <? if(!isset($_GET["edit"])) {?><input class="ui-button ui-widget ui-corner-all"  type="reset" value="Очистить"><? } ?></p>
 </form>
 <? if(isset($_GET["edit"]))exit("<p><a class=\"ui-button ui-widget ui-corner-al\"   href=\"/specialization.php\">Вернуться назад</a></p></body></html>"); ?>
 <table class="heavyTable" class="price-table" border="1">
   <caption>Все должности: <br></caption>
   <tr class="price-column">
    <th><a href="#">ID</a></th>
    <th><a href="#">Наименование</a></th>
	  <th><a href="#">Почасовая ставка</a></th>
   </tr>
   <?
	 $q="SELECT COUNT(*) as `c` FROM `specialization`";
	 $q=mysqli_query($link,$q);
	 $q=mysqli_fetch_array($q);
	 $c=$q["c"];

	 $page = $_GET["page"] ?? 1;
	 $start = ($page-1)*PAGE_MAX;
	 $pages= intval($c/PAGE_MAX);
	 if($pages*PAGE_MAX < $c) $pages++;

	 $q="SELECT * FROM `specialization`";
	 $q.=" LIMIT $start, ".PAGE_MAX;

		$q=mysqli_query($link,$q);
		$empty=true;
		while($a=mysqli_fetch_array($q))
		{
			$empty=false;
			echo "<tr><td><a href=\"/specialization.php?edit=".$a['id']."\" title=\"Изменить\">".$a['id']." &#9998;</a>  <a href=\"/specialization.php?delete=".$a['id']."\" title=\"Удалить\"> &#10008;</a></td>";
			echo "<td>".$a['Name']."</td>";
			echo "<td>".$a['hour_salary']."</td></td></tr>";
		}
		if($empty) echo '<tr><td colspan="3"><h2>Записей нет.</h2></td></tr>';
		else {
			echo '<tr><td class="paginator" colspan="3">';
				for($i=1;$i<=$pages;$i++) {
					if($i!=$page)
						echo '<a href="/specialization.php?page='.$i.'"> '.$i.' </a>';
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
