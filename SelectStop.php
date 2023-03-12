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

$Stop_ID = $_GET["Stop_ID"];
//echo "Route_ID=".$Route_ID."<br>";
$sql3 = 'select `StopInRoute`.*, `Route`.`Route_ID`, `Route`.`Type`, `Route`.`Number`, `Route`.Comment from (`StopInRoute` inner join' .
    ' `Route` on `StopInRoute`.`Route_ID` = `Route`.`Route_ID`) where `StopInRoute`.`Stop_ID` =' .
    $Stop_ID;
$result = mysql_query($sql3);
$index = 0;

echo '<tr><th>Route_ID </th><th>Номер на остановке</th><th>Тип ТС</th><th>Номер</th><th>Маршрут</th></tr>';
while ($row = mysql_fetch_row($result)) {
    echo '<tr onclick=TRClick2(' . $index++ . ')>';
    echo '<td >' . $row[0] . '</td>';
    echo '<td >' . $row[1] . '</td>';
    echo '<td>' . $row[4] . '</td>';
    echo '<td>' . $row[5] . '</td>';
    echo '<td>' . $row[6] . '</td> </tr>';
}
