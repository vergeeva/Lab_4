<html>

<head>
    <title>������������ ������</title>
</head>

<body>
    <?php
    // ������������ � ���� ������ access
    $db = 'b:\home\localhost\www\Lab_4\Transport.mdb';
    $conn = new COM('ADODB.Connection');
    $conn->Open("Provider=Microsoft.Jet.OLEDB.4.0; Data Source=" . $db);
    // ������������ � MySQL-�������
    $s = @mysql_connect("localhost", "root", "123456");
    if (!$s) {
        echo ('������ ����������� � MySQL-�������.��� ������:' . mysql_error());
    } //if
    // ������������ � ���� ������ transport �� MySQL-�������
    $d = @mysql_select_db("transport", $s);
    if (!$d) {
        echo ('������ ����������� � ���� ������. ��� ������: ' . mysql_error());
    } // if
    // ������������� ��������� cp1251 ��� ������ � MySQL-��������
    mysql_query('SET NAMES cp1251');

    mysql_query("TRUNCATE TABLE `Route`");
    $sql = 'SELECT * FROM Route';
    $rs = $conn->Execute($sql);
    // �������� ����� ������ �� ������� Route ���� ������ access
    $sql = 'SELECT * FROM Route';
    $rs = $conn->Execute($sql);
    // �������� �� ������ ������
    for ($i = 0; !$rs->EOF; $i++) {
        $Route_ID = $rs->Fields['Route_ID']->Value;
        $Type = $rs->Fields['Type']->Value;
        $Number = $rs->Fields['Number']->Value;
        $Comment = $rs->Fields['Comment']->Value;
        $rs->MoveNext();
        // ��������� ������ ������� �� MySQL-�������
        $result = mysql_query("INSERT INTO `Route` (`Type`, `Number`,
`Comment` ) VALUES ('" . $Type . "','" . $Number . "','" . $Comment . "')");
    } // for
    echo "���������� ������� Route ���������<br>";

    mysql_query("TRUNCATE TABLE `Stop`");
    $sql1 = 'SELECT * FROM Stop';
    $rs = $conn->Execute($sql1);
    // �������� ����� ������ �� ������� Route ���� ������ access
    $sql = 'SELECT * FROM Stop';
    $rs = $conn->Execute($sql);
    // �������� �� ������ ������
    for ($i = 0; !$rs->EOF; $i++) {
        $Stop_ID = $rs->Fields['Stop_ID']->Value;
        $Name = $rs->Fields['Name']->Value;
        $rs->MoveNext();
        // ��������� ������ ������� �� MySQL-�������
        $result = mysql_query("INSERT INTO `Stop` (`Name`) VALUES ('" . $Name . "')");
    } // for
    echo "���������� ������� Stop ���������<br>";

    mysql_query("TRUNCATE TABLE `StopInRoute`");
    // �������� ����� ������ �� ������� Route ���� ������ access
    $sql2 = 'SELECT * FROM StopInRoute';
    $rs = $conn->Execute($sql2);
    // �������� �� ������ ������
    for ($i = 0; !$rs->EOF; $i++) {
        $Route_ID = $rs->Fields['Route_ID']->Value;
        $StopNumb = $rs->Fields['StopNumb']->Value;
        $Stop_ID = $rs->Fields['Stop_ID']->Value;
        $rs->MoveNext();
        // ��������� ������ ������� �� MySQL-�������
        $result = mysql_query("INSERT INTO `StopInRoute` (`Route_ID`, `StopNumb`, `Stop_ID`) VALUES ('" . $Route_ID . "','" . $StopNumb . "','" . $Stop_ID . "')");
    } // for
    echo "���������� ������� StopInRoute ���������<br>";
    ?>
</body>

</html>