<?php
header ("Content-Type: text/html; charset=utf-8");

include "include/config.php";
include "include/mysql.php";


include "include/header.php";
?>
<body> <br><br>
<section id="content">
<article><h2>Это главная страница сервиса! Для выбора используйте таблицу ниже.<h2></article>
  <table style="width:600px" class="heavyTable price-table" border="1">
      <tr class="price-column">
      <th><a href="#">Справочники</a></th>
      <th><a href="#">Формы</a></th>
    </tr>
    <tr>
   		<td><a class="ui-button ui-widget ui-corner-all"  href="/clients.php">Клиенты</a></td>
   		<td><a class="ui-button ui-widget ui-corner-all"  href="/workorder.php">Заказ-наряды</a></td>
    </tr>
    <tr>
   		<td><a class="ui-button ui-widget ui-corner-all"  href="/cars.php">Автомобили</a></td>
   		<td></td>
    </tr>
    <tr>
   		<td><a class="ui-button ui-widget ui-corner-all"  href="/masters.php">Мастера</a></td>
   		<td></td>
    </tr>
    <tr>
   		<td><a class="ui-button ui-widget ui-corner-all"  href="/parts.php">Запчасти</a></td>
   		<td></td>
    </tr>
    <tr>
   		<td><a class="ui-button ui-widget ui-corner-all"  href="/price.php">Услуги</a></td>
   		<td></td>
    </tr>
    <tr>
   		<td><a class="ui-button ui-widget ui-corner-all"  href="/specialization.php">Должности</a></td>
   		<td></td>
    </tr>
    </table>
</section>
<?php include "include/footer.php"; ?>
