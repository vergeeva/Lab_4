<?php
header('Content-Type: text/html; charset=windows-1251');

//Подключение к базе данных
$s = @mysql_connect("localhost", "root", "123456");
if (!$s) {
    echo ('Ошибка подключения к серверу с кодом: ' . mysql_error());
}
$d = @mysql_select_db("Transport", $s);
if (!$d) {
    echo ('Ошибка подключения к базе данных с кодом:' . mysql_error());
}
mysql_query('SET NAMES cp1251');

$Type = $_GET["Type"];
$result = mysql_query("SELECT `Route_ID`, `Number` FROM `Route` where Type='".$Type."'");

//echo '<tr><th>Id </th><th>Тип ТС</th><th>Номер</th><th>Маршрут</th></tr>';
while ($row = mysql_fetch_row($result)) {
    echo '<option value='.$row[0].'>'.$row[1].'</option>';
}
