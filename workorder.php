<?php
header ("Content-Type: text/html; charset=utf-8");

include "include/config.php";
include "include/mysql.php";
include "include/header.php";
?>

<body>

<header>
	<nav id="nav">
	  <a class="ui-button ui-widget ui-corner-all"  href="/">Главная</a>
		<a class="ajax ui-button ui-widget ui-corner-all"  href="/forms/open.workorder.php">Открыть заказ наряд</a>
	</nav>

</header>
<section id="content">
<article>
 <table style="width:1200px" class="heavyTable price-table" border="1">
   <caption>Все заказ-наряды <br></caption>
	 <tr class="price-column">
		<th><a href="#"> Машина</a></th>
		<th><a href="#"> Заказчик</a></th>
		<th><a href="#"> Описание </a></th>
		<th><a href="#"> Мастер </a></th>
		<th><a href="#"> Челевеко-часы </a></th>
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

		$q="SELECT `workorder`.`id`, `date_start`,`date_end`,`Description`, `human_hour`, `cars`.`Name` as `cName`,`clients`.`Name`,`clients`.`Phone`, `masters`.`Name` as `mName`, `masters`.`Phone` as `mPhone` FROM `workorder` JOIN `cars` ON `workorder`.`Cars_id`=`cars`.`id` JOIN `clients` ON `cars`.`clients_id`=`clients`.`id` JOIN `masters` ON `Masters_id`=`masters`.`id`"; // Начальный запрос
		$q.=" LIMIT $start, ".PAGE_MAX;


		$q=mysqli_query($link,$q);
		$empty=true;
		while($a=mysqli_fetch_array($q))
		{
			$empty=false;
		 $a['human_hour']=$a['human_hour']??0;
			echo "<tr><td><a href=\"/card.workorder.php?id=".$a['id']."\" title=\"Карточка\">".$a['cName']."<a class=\"ajax\" href=\"/forms/delete.workorder.php?id=".$a['id']."\" title=\"Удалить\"> &#10008;</a></td>";
			echo "<td>".$a['Name']."<br>(".$a['Phone'].")</td>";
			echo "<td>".$a['Description']."</td>";
			echo "<td>".$a['mName']."<br>(".$a['mPhone'].")</td>";
			echo "<td><a class=\"ajax\" href=\"/form/hh.workorder.php?id=".$a['id']."\">".$a['human_hour']."</a></td></tr>";
		}
		if($empty) echo '<tr><td colspan="7"><h2>Записей нет.</h2></td></tr>';
		else {
			echo '<tr><td class="paginator" colspan="7">';
				for($i=1;$i<=$pages;$i++) {
					if($i!=$page)
						echo '<a href="/workorder.php?page='.$i.'"> '.$i.' </a>';
					else
						echo '<b> '.$i.' </b>';
				}
			echo '</td></tr>';
		}

   ?>
   </table>
</article>
</section>
<div id="modal-ajax"></div>
<div id="modal-alert"></div>
<?php include "include/footer.php"; ?>
