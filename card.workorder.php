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
		<a class="ui-button ui-widget ui-corner-all"  href="/workorder.php">Заказ-наряды</a>
	</nav>

</header>
<section id="content">
<article>

	<table style="width:1200px" class="heavyTable price-table" border="1">
    <caption>Карточка заказ-наряда <br></caption>
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

     $q="SELECT `workorder`.`id`, `date_start`,`date_end`,`Description`, `human_hour`, `cars`.`Name` as `cName`,`clients`.`Name`,`clients`.`Phone`, `masters`.`Name` as `mName`, `masters`.`Phone` as `mPhone` FROM `workorder` JOIN `cars` ON `workorder`.`Cars_id`=`cars`.`id` JOIN `clients` ON `cars`.`clients_id`=`clients`.`id` JOIN `masters` ON `Masters_id`=`masters`.`id`"; // Начальный запрос
     $q.=" WHERE `workorder`.`id`=".$_GET["id"];

		 $open = true;
     	$q=mysqli_query($link,$q);
			while($a=mysqli_fetch_array($q)){
			if(strlen($a['date_end'])>5) $open=false;
 			$a['human_hour']=$a['human_hour']??0;
       echo "<tr><td><a href=\"#\">".$a['cName']."</a></td>";
       echo "<td>".$a['Name']."<br>(".$a['Phone'].")</td>";
       echo "<td>".$a['Description']."</td>";
       echo "<td>".$a['mName']."<br>(".$a['mPhone'].")</td>";
       echo "<td><a class=\"ajax\" href=\"/form/hh.workorder.php?id=".$a['id']."\">".$a['human_hour']."</a></td></tr>";
		 }
		 if($open)
		 	echo "<tr><td colspan=\"5\"><a class=\"ajax ui-button ui-widget ui-corner-all\"  href=\"/forms/close.workorder.php?id=".$_GET["id"]."\">Закрыть заказ-наряд</a></td></tr>";
		 ?>
    </table>
		</article>
		<article>
		 <table style="width:1200px" class="heavyTable price-table" border="1">
		   <caption>Выполненные работы<br></caption>
			 <tr class="price-column">
				<th><a href="#"> Наименование</a></th>
				<th><a href="#"> Цена</a></th>
				<th><a href="#"> Количество </a></th>
				<th><a href="#"> Сумма </a></th>
			 </tr>
		<?
				$q="SELECT `priceforworkorder`.`id`,`priceforworkorder`.`ammount`,`priceforworkorder`.`total_cost`,`price`.`Name`,`price`.`Price` FROM `priceforworkorder` JOIN `price` ON `priceforworkorder`.`Price_id`=`price`.`id`";
				$q.=" WHERE `priceforworkorder`.`WorkOrder_id`=".$_GET["id"];

				$q=mysqli_query($link,$q);
				$empty=true;
				$SUM=0;
				while($a=mysqli_fetch_array($q))
				{
					$empty=false;
					echo "<tr><td>".$a['Name']."<a class=\"ajax\" href=\"/forms/delete.price.workorder.php?id=".$a['id']."\" title=\"Удалить\"> &#10008;</a></td>";
					echo "<td>".$a['Price']."</td>";
					echo "<td>".$a['ammount']."</td>";
					echo "<td>".$a['total_cost']."</td>";
					$SUM+=$a['total_cost'];
				}
				if($empty) echo '<tr><td colspan="4"><h2>Записей нет.</h2></td></tr>';
				else echo '<tr><td colspan="3"><h2>ИТОГО (за работу):</h2></td><td>'.$SUM.'</td></tr>';
				if($open)
				echo "<tr><td colspan=\"4\"><a class=\"ajax ui-button ui-widget ui-corner-all\"  href=\"/forms/add.price.workorder.php?id=".$_GET["id"]."\">Добавить</a></td></tr>";
				 ?>

		   </table>
			 		</article>

					<article>
					 <table style="width:1200px" class="heavyTable price-table" border="1">
					   <caption>Запчасти<br></caption>
						 <tr class="price-column">
							<th><a href="#"> Наименование</a></th>
							<th><a href="#"> Цена</a></th>
							<th><a href="#"> Количество </a></th>
							<th><a href="#"> Сумма </a></th>
						 </tr>
					<?
							$q="SELECT `partsforworkorder`.`id`,`partsforworkorder`.`ammount`,`partsforworkorder`.`total_cost`,`parts`.`Name`,`parts`.`Price` FROM `partsforworkorder` JOIN `parts` ON `partsforworkorder`.`Parts_id`=`parts`.`id`";
							$q.=" WHERE `partsforworkorder`.`WorkOrder_id`=".$_GET["id"];

							$q=mysqli_query($link,$q);
							$empty=true;
							$SUM=0;
							while($a=mysqli_fetch_array($q))
							{
								$empty=false;
								echo "<tr><td>".$a['Name']."<a class=\"ajax\" href=\"/forms/delete.price.workorder.php?id=".$a['id']."\" title=\"Удалить\"> &#10008;</a></td>";
								echo "<td>".$a['Price']."</td>";
								echo "<td>".$a['ammount']."</td>";
								echo "<td>".$a['total_cost']."</td>";
								$SUM+=$a['total_cost'];
							}
							if($empty) echo '<tr><td colspan="4"><h2>Записей нет.</h2></td></tr>';
							else echo '<tr><td colspan="3"><h2>ИТОГО (за запчасти):</h2></td><td>'.$SUM.'</td></tr>';
							if($open)
							echo "<tr><td colspan=\"4\"><a class=\"ajax ui-button ui-widget ui-corner-all\"  href=\"/forms/add.parts.workorder.php?id=".$_GET["id"]."\">Добавить</a></td></tr>";
							 ?>

					   </table>
						 		</article>
</section>
<div id="modal-ajax"></div>
<div id="modal-alert"></div>
<?php include "include/footer.php"; ?>
