<?
include "../include/config.php";
include "../include/mysql.php";?>

<form name="open.workorder" actions="/ajax/open.workorder.php">
  <p><b>Машина:</b>
    <select name="Cars_id" id="salutation">
      <option disabled selected>Выберите:</option>
      <?
        $q="SELECT `cars`.`id`, `cars`.`Name` as `cName`, `clients`.`Name` FROM `cars` JOIN `clients` ON `cars`.`clients_id`=`clients`.`id`"; // Начальный запрос
        $q=mysqli_query($link,$q);
        while($a=mysqli_fetch_array($q))
            echo "<option value=\"".$a["id"]."\">".$a["cName"]." (".$a["Name"].")</option>";
       ?>
    </select></p>

    <p><b>Мастер:</b>
      <select name="Masters_id" id="salutation">
        <option disabled selected>Выберите:</option>
        <?
          $q="SELECT * FROM `masters`"; // Начальный запрос
          $q=mysqli_query($link,$q);
          while($a=mysqli_fetch_array($q))
              echo "<option value=\"".$a["id"]."\">".$a["Name"]."</option>";
         ?>
      </select></p>
  <p><b>Описание:</b><input class="ui-spinner-input" name="Description" type="text" size="60"></p>
  <p>Дата открытия: <input name="date_start" type="text" id="datepicker"></p>
  </form>
