<html>

<head>
    <title>�������</title>
</head>

<body>
    <?php
    $s = @mysql_connect("localhost", "root", "123456");
    if (!$s) {
        echo('������ ����������� � ������� � �����: ' . mysql_error());
    }
    $d = @mysql_select_db("Transport", $s);
    if (!$d) {
        echo ('������ ����������� � ���� ������ � �����:'.mysql_error());
    }
    mysql_query('SET NAMES cp1251');

    //������� Route

    $result = mysql_query("SELECT * FROM `Route`");
    $s = "<table border=1>\n";
    $s = $s . "<tr><th>ID</th><th>��� ��</th><th>�����</th><th>�����������</th>" .
        "</tr>";
    while ($row = mysql_fetch_row($result)) {
        $s = $s . "<tr>";
        for ($i = 0; $i < 4; $i++) {
            $f = $row[$i];
            $s = $s . "<td>" . $f . "</td>";
        } // for
        $s = $s . "</tr>";
    } // while
    $s = $s . "</table>\n";
    echo $s;

    //������� Stop

    $result = mysql_query("SELECT * FROM `Stop`");
    $s = "<table border=1>\n";
    $s = $s . "<tr><th>ID</th><th>��������</th>";
    while ($row = mysql_fetch_row($result)) {
        $s = $s . "<tr>";
        for ($i = 0; $i < 2; $i++) {
            $f = $row[$i];
            $s = $s . "<td>" . $f . "</td>";
        } // for
        $s = $s . "</tr>";
    } // while
    $s = $s . "</table>\n";
    echo $s;

    //������� StopInRoute

    $result = mysql_query("SELECT * FROM `StopInRoute`");
    $s = "<table border=1>\n";
    $s = $s . "<tr><th>Route_ID</th><th>StopNumb</th><th>Stop_ID</th>";
    while ($row = mysql_fetch_row($result)) {
        $s = $s . "<tr>";
        for ($i = 0; $i < 3; $i++) {
            $f = $row[$i];
            $s = $s . "<td>" . $f . "</td>";
        } // for
        $s = $s . "</tr>";
    } // while
    $s = $s . "</table>\n";
    echo $s;
    ?>
</body>

</html>