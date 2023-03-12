<html>

<head>
    <title>Перегагрузка таблиц</title>
</head>

<body>
    <?php
    // Подключаемся к базе данных access
    $db = 'b:\home\localhost\www\Lab_4\Transport.mdb';
    $conn = new COM('ADODB.Connection');
    $conn->Open("Provider=Microsoft.Jet.OLEDB.4.0; Data Source=" . $db);
    // Подключаемся к MySQL-серверу
    $s = @mysql_connect("localhost", "root", "123456");
    if (!$s) {
        echo ('Ошибка подключения к MySQL-серверу.Код ошибки:' . mysql_error());
    } //if
    // Подключаемся к базе данных transport на MySQL-сервере
    $d = @mysql_select_db("transport", $s);
    if (!$d) {
        echo ('Ошибка подключения к базе данных. Код ошибки: ' . mysql_error());
    } // if
    // Устанавливаем кодировку cp1251 при работе с MySQL-сервером
    mysql_query('SET NAMES cp1251');

    mysql_query("TRUNCATE TABLE `Route`");
    $sql = 'SELECT * FROM Route';
    $rs = $conn->Execute($sql);
    // Получаем набор данных из таблицы Route базы данных access
    $sql = 'SELECT * FROM Route';
    $rs = $conn->Execute($sql);
    // Проходим по набору данных
    for ($i = 0; !$rs->EOF; $i++) {
        $Route_ID = $rs->Fields['Route_ID']->Value;
        $Type = $rs->Fields['Type']->Value;
        $Number = $rs->Fields['Number']->Value;
        $Comment = $rs->Fields['Comment']->Value;
        $rs->MoveNext();
        // Формируем строку таблицы на MySQL-сервере
        $result = mysql_query("INSERT INTO `Route` (`Type`, `Number`,
`Comment` ) VALUES ('" . $Type . "','" . $Number . "','" . $Comment . "')");
    } // for
    echo "Перегрузка таблицы Route завершена<br>";

    mysql_query("TRUNCATE TABLE `Stop`");
    $sql1 = 'SELECT * FROM Stop';
    $rs = $conn->Execute($sql1);
    // Получаем набор данных из таблицы Route базы данных access
    $sql = 'SELECT * FROM Stop';
    $rs = $conn->Execute($sql);
    // Проходим по набору данных
    for ($i = 0; !$rs->EOF; $i++) {
        $Stop_ID = $rs->Fields['Stop_ID']->Value;
        $Name = $rs->Fields['Name']->Value;
        $rs->MoveNext();
        // Формируем строку таблицы на MySQL-сервере
        $result = mysql_query("INSERT INTO `Stop` (`Name`) VALUES ('" . $Name . "')");
    } // for
    echo "Перегрузка таблицы Stop завершена<br>";

    mysql_query("TRUNCATE TABLE `StopInRoute`");
    // Получаем набор данных из таблицы Route базы данных access
    $sql2 = 'SELECT * FROM StopInRoute';
    $rs = $conn->Execute($sql2);
    // Проходим по набору данных
    for ($i = 0; !$rs->EOF; $i++) {
        $Route_ID = $rs->Fields['Route_ID']->Value;
        $StopNumb = $rs->Fields['StopNumb']->Value;
        $Stop_ID = $rs->Fields['Stop_ID']->Value;
        $rs->MoveNext();
        // Формируем строку таблицы на MySQL-сервере
        $result = mysql_query("INSERT INTO `StopInRoute` (`Route_ID`, `StopNumb`, `Stop_ID`) VALUES ('" . $Route_ID . "','" . $StopNumb . "','" . $Stop_ID . "')");
    } // for
    echo "Перегрузка таблицы StopInRoute завершена<br>";
    ?>
</body>

</html>