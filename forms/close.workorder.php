<?
include "../include/config.php";
include "../include/mysql.php";?>

<form name="open.workorder" actions="/ajax/close.workorder.php">
  <input name="id" type="hidden" value="<?=$_GET["id"];?>" />
  <p>Человеко-часы: <input name="human_hour" type="text" id="spinner"></p>
  <p>Дата закрытия: <input name="date_end" type="text" id="datepicker"></p>
  </form>
