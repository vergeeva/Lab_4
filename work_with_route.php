<html>

<head>
    <title>������ � �������� ��������</title>
</head>

<body>
    <?
    /*foreach ($_POST as $key => $el) {
        echo "����: " . $key . "   ��������: " . $el . "<br>";
    }*/
    $Oper = $_POST['NOper']; // ����� ��������
    $StopNumb = $_POST['NStopNumb']; // ����� �� ���������
    $Route_ID = $_POST['NRouteID'];
    $Stop_ID = $_POST['NStopID'];
    if ($Oper == '2' || $Oper == '3') {
        $OldRoute_ID = $_POST['NOldRouteID'];
        $OldStopNumb = $_POST['NOldStopNumb'];
    } // if

    $s = @mysql_connect("localhost", "root", "123456");
    if (!$s) {
        echo ('������ ����������� � ������� � �����: ' . mysql_error());
    }
    $d = @mysql_select_db("Transport", $s);
    if (!$d) {
        echo ('������ ����������� � ���� ������ � �����:' . mysql_error());
    }
    mysql_query('SET NAMES cp1251');

	//INSERT INTO `StopInRoute` ( `Route_ID` , `StopNumb` , `Stop_ID` ) VALUES ( '1', '4', '1' );
    if ($Oper == '1') {
		mysql_query("INSERT INTO `StopInRoute` ( `Route_ID` , `StopNumb` , `Stop_ID` ) VALUES ( '".$Route_ID."', '".$StopNumb."', '".$Stop_ID."' )");
    } // if
    if ($Oper == '2') {
        mysql_query("UPDATE `StopInRoute` SET `Route_ID`=" . $Route_ID . ", `StopNumb`=" . $StopNumb ." WHERE `Stop_ID`=" . $Stop_ID . " AND `StopNumb`=" . $OldStopNumb."");
    } // if
    if ($Oper == '3') {
        mysql_query("DELETE FROM `StopInRoute` WHERE `Route_ID`=" . $Route_ID . " AND `StopNumb`=" . $OldStopNumb);
    } // if

    if ($Oper == '1') {
        echo "<h1>��������� �� �������� ���������</h1>";
    }
    if ($Oper == '2') {
        echo "<h1>��������� �� �������� ��������</h1>";
    }
    if ($Oper == '3') {
        echo "<h1>��������� �� �������� �������</h1>";
    } // if 
    ?>

    <a href="http://localhost:8080/Lab_4/main.php">�������</2>
</body>

</html>