<?
include "../include/config.php";
include "../include/mysql.php";?>

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

   $page = $_GET["page"] ?? 1;
   $start = ($page-1)*PAGE_MAX;
   $pages= intval($c/PAGE_MAX);
   if($pages*PAGE_MAX < $c) $pages++;

   $q="SELECT `workorder`.`id`, `date_start`,`date_end`,`Description`, `human_hour`, `cars`.`Name` as `cName`,`clients`.`Name`,`clients`.`Phone`, `masters`.`Name` as `mName`, `masters`.`Phone` as `mPhone` FROM `workorder` JOIN `cars` ON `workorder`.`Cars_id`=`cars`.`id` JOIN `clients` ON `cars`.`clients_id`=`clients`.`id` JOIN `masters` ON `Masters_id`=`masters`.`id`"; // Начальный запрос
   $q.=" WHERE `workorder`.`id`=".$_GET["id"];


   $q=mysqli_query($link,$q);
   $empty=true;
   while($a=mysqli_fetch_array($q))
   {
     $empty=false;
     echo "<tr><td><a class=\"ajax\" href=\"/form/card.workorder.php?id=".$a['id']."\" title=\"Удалить\">".$a['cName']."<a class=\"ajax\" href=\"/forms/delete.workorder.php?id=".$a['id']."\" title=\"Удалить\"> &#10008;</a></td>";
     echo "<td>".$a['Name']."(".$a['Phone'].")</td>";
     echo "<td>".$a['Description']."</td>";
     echo "<td>".$a['mName']."(".$a['mPhone'].")</td>";
     echo "<td><a class=\"ajax\" href=\"/form/hh.workorder.php?id=".$a['id']."\">".$a['human_hour']."</a></td></tr>";
   }
   ?>
  </table>

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
