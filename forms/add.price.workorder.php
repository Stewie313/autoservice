<?
include "../include/config.php";
include "../include/mysql.php";?>

<form name="open.workorder" actions="/ajax/add.price.workorder.php">
  <p><b>Машина:</b>
    <select name="Price_id" id="salutation">
      <option disabled selected>Выберите работу:</option>
      <?
        $q="SELECT * FROM `price`";
        $q=mysqli_query($link,$q);
        while($a=mysqli_fetch_array($q))
            echo "<option value=\"".$a["id"]."\">".$a["Name"]." (".$a["Price"].")</option>";
       ?>
    </select></p>

  <p><b>Количество:</b><input id="spinner" class="ui-spinner-input" name="ammount" type="text" size="30"></p>
  <input name="WorkOrder_id" type="hidden" value="<?=$_GET["id"];?>"/>
  </form>
