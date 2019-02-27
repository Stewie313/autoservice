<?php
header ("Content-Type: text/html; charset=utf-8");

include "include/config.php";
include "include/mysql.php";


if(isset($_GET["edit"])){
	$q=mysqli_query($link,"SELECT * FROM `parts` WHERE `id`=".$_GET["edit"]);
	$a=mysqli_fetch_array($q);
	$id=$a["id"];
	$name=$a["Name"];
	$price=$a["Price"];
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
	$q="UPDATE `parts` SET `Name` = '".$_POST["name"]."', `Price` = '".$_POST["price"]."', `correct_for` = '".$_POST["correct_for"]."' WHERE `id` = ".$_POST["id"].";";
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
	if($_POST["price"]<1){
		$title="Ошибка!";
		$status="Стоимость запчасти не может быть меньше 1!";
	} else {
		$query="INSERT INTO `parts` (`id`, `Name`, `Price`, `correct_for`) VALUES (NULL, '".$_POST["name"]."', '".$_POST["price"]."', '".$_POST["correct_for"]."');";
		if(mysqli_query($link,$query)) {
			$title="Успех!";
			$status="Запчасть успешно добавлена!";
		}
		else {
			$title="Ошибка!";
			$status="При добавление запчасти произошла ошибка!";
		}
	}
	$opendiag=true;
}
else if(isset($_GET["delete"]))
{
	$query="DELETE FROM `parts` WHERE `id`=".$_GET["delete"].";";
	if(mysqli_query($link,$query)) {
		$title="Успех!";
		$status="Запчасть успешно удалена!";
	}
	else {
		$title="Ошибка!";
		$status="При удалении запчасти произошла ошибка!";
	}
	$opendiag=true;
}
?>

<form name="new_client" method="post" action="parts.php">
	<? if(!isset($_GET["edit"])) {?>
  <h2 class="pad">Добавление новой запчасти:</h2>
<? } else {?>
	<h2 class="pad">Редактирование запчасти:</h2>
	<? }?>
  <input name="id" type="hidden" size="8" value="<?=$id?>">
  <p><b>Наименование:</b><input class="ui-spinner-input" name="name" type="text" size="40" value="<?=$name?>"></p>
  <p><b>Стоимость:</b><input id="spinner2" class="ui-spinner-input" name="price" type="text" size="40" value="<?=$price??50;?>"></p>
  <p><b>Подходит для:</b><input class="ui-spinner-input" name="correct_for" type="text" size="40" value="<?=$correct_for??"All";?>"></p>
	<p><input class="ui-button ui-widget ui-corner-all"   type="submit" value="<? if(isset($_GET["edit"])) echo "Обновить"; else echo "Добавить";?>">
  <? if(!isset($_GET["edit"])) {?><input class="ui-button ui-widget ui-corner-all"  type="reset" value="Очистить"><? } ?></p>
 </form>
 <? if(isset($_GET["edit"]))exit("<p><a class=\"ui-button ui-widget ui-corner-al\"   href=\"/parts.php\">Вернуться назад</a></p></body></html>"); ?>
 <table class="heavyTable" class="parts-table" border="1">
   <caption>Все запчасти: <br></caption>
   <tr class="parts-column">
    <th><a href="#">ID</a></th>
    <th><a href="#">Наименование</a></th>
	  <th><a href="#">Стоимость</a></th>
	  <th><a href="#">Подходит для:</a></th>
   </tr>
   <?
	 $q="SELECT COUNT(*) as `c` FROM `parts`";
	 $q=mysqli_query($link,$q);
	 $q=mysqli_fetch_array($q);
	 $c=$q["c"];

	 $page = $_GET["page"] ?? 1;
	 $start = ($page-1)*PAGE_MAX;
	 $pages= intval($c/PAGE_MAX);
	 if($pages*PAGE_MAX < $c) $pages++;

	 $q="SELECT * FROM `parts`";
	 $q.=" LIMIT $start, ".PAGE_MAX;

		$q=mysqli_query($link,$q);
		$empty=true;
		while($a=mysqli_fetch_array($q))
		{
			$empty=false;
			echo "<tr><td><a href=\"/parts.php?edit=".$a['id']."\" title=\"Изменить\">".$a['id']." &#9998;</a>  <a href=\"/parts.php?delete=".$a['id']."\" title=\"Удалить\"> &#10008;</a></td>";
			echo "<td>".$a['Name']."</td>";
			echo "<td>".$a['Price']."</td>";
			echo "<td>".$a['correct_for']."</td></tr>";
		}
		if($empty) echo '<tr><td colspan="4"><h2>Записей нет.</h2></td></tr>';
		else {
			echo '<tr><td class="paginator" colspan="4">';
				for($i=1;$i<=$pages;$i++) {
					if($i!=$page)
						echo '<a href="/parts.php?page='.$i.'"> '.$i.' </a>';
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
