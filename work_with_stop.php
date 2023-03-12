	<html>

<head>
    <title>Работа с таблицей остановки</title>
</head>

<body>
    <?
    $Oper = $_POST['NOper'];
    if ($Oper == '1' || $Oper == '2') {
        $Name = $_POST['NameStop'];
    } // if
    if ($Oper == '2' || $Oper == '3') {
        $ID = $_POST['NID'];
    } // if

    $s = @mysql_connect("localhost", "root", "123456");
    if (!$s) {
        echo ('Ошибка подключения к серверу с кодом: ' . mysql_error());
    }
    $d = @mysql_select_db("Transport", $s);
    if (!$d) {
        echo ('Ошибка подключения к базе данных с кодом:' . mysql_error());
    }
    mysql_query('SET NAMES cp1251');

    if ($Oper == '1') {
        mysql_query("INSERT INTO `Stop` ( `Name` ) VALUES ('".$Name."');");
    } // if
    if ($Oper == '2') {
        mysql_query("UPDATE `Stop` SET `Name` = '" . $Name . "' WHERE `Stop_ID` =" . $ID . "");
    } // if
    if ($Oper == '3') {
        mysql_query("DELETE FROM `Stop` WHERE `Stop_ID`=" . $ID . "");
    } // if
    //mysql_query($sql);
    if ($Oper == '1') {
        echo "<h1>Добавлен маршрут</h1>";
        echo "<table border=0>";
        echo "<tr><td>Название</td><td>" . $Name . "</td></tr>";
        echo "</table>";
    } // if
    if ($Oper == '2') {
        echo "<h1>Изменен маршрут</h1>";
        echo "<table border=0>";
        echo "<tr><td>Название</td><td>" . $Name . "</td></tr>";
        echo "</table>";
    } // if
    if ($Oper == '3') {
        echo "<h1>Удален маршрут</h1>";
        echo "<table border=0>";
        echo "<tr><td>ID</td><td>" . $ID . "</td></tr>";
        echo "</table>";
    } // if 
    ?>
    <a href="http://localhost:8080/Lab_4/main.php">Возврат</2>
</body>

</html>