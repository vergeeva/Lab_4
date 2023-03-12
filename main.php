<html>

<head>
    <title>Транспорт города Челябинск</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
    <?php
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
    ?>
    <h1>Остановки</h1>
        <table id="table1" border="0">
            <tr class="tr_inline">
                <td>
                    <table id="table2" border="1">
                        <tr>
                            <th hidden>ID</th>
                            <th>Название</th>
                        </tr>
                        <?php
                        $result = mysql_query("SELECT * FROM `Stop`");
                        $index = 0;
                        while ($row = mysql_fetch_row($result)) {
                        ?>
                            <tr <?php echo 'onclick=TRClick(' . $index++ . ')' ?>>
                                <td hidden>
                                    <?php echo $row['0']; ?>
                                </td>
                                <td>
                                    <?php echo $row['1']; ?>
                                </td>
                            </tr>
                        <?php }; ?>
                    </table>
                </td>
                <td>
                    <input type="button" value="Добавить" onclick="InsertClick()"><br><br>
                    <input type="button" value="Изменить" onclick="UpdateClick()"><br><br>
                    <input type="submit" value="Удалить" onclick="DeleteClick()">
                </td>
                <td>
                    <form id="form_stop" method="POST" action="work_with_stop.php" hidden>
                        <p>Название остановки<br>
                            <input type="text" name="NameStop" id="INameStop">
                        </p>
                        <p><input type="submit" value="   OK   " id="IOK">
                            <input type="button" value="Отмена " onclick="CancelClick()" id="Cancel">
                        </p>
                        <div hidden>
                            <input type="text" name="NID" id="IID">
                            <input type="text" name="NOper" id="IOper">
                        </div>
                    </form>
                </td>
            </tr>
            <tr class="tr_inline">
                <td>
                    <h1>Транспорт</h1>
                    <table id="table3" border="1"></table>
                </td>
                <td>
                    <input type="button" value="Добавить" onclick="InsertClick2()"><br><br>
                    <input type="button" value="Изменить" onclick="UpdateClick2()"><br><br>
                    <input type="submit" value="Удалить  " onclick="DeleteClick2()">
                </td>
                <td>
                    <form id="form_route" method="POST" action="work_with_route.php" hidden>
                        <p>Номер на остановке<br>
                            <input type="text" name="NStopNumb" id="IStopNumb">
                        </p>

                        Тип<br>
                        <select name="NType" id="IType" onchange="change_select_transport_type()">
                            <option>Автобус</option>
                            <option>Троллейбус</option>
                            <option>Трамвай</option>
                        </select><br><br>
                        Номер<br>

                        <select type="text" name="NRouteID" id="IRouteID">
                            <?php
                            $result = mysql_query("SELECT `Route_ID`, `Number` FROM `Route` where Type='Автобус'");
                            while ($row = mysql_fetch_row($result)) {
                                echo '<option value=' . $row[0] . '>' . $row[1] . '</option>';
                            }
                            ?>
                        </select><br><br>

                        <input type="submit" value="   OK   " ID="IOK2">
                        <input type="button" value="Отмена " onclick="CancelClick2()" id="Cancel2"><br>

                        <div hidden><input type="text" name="NStopID" id="IStopID">
                            <input type="text" name="NOldRouteID" id="IOldRouteID">
                            <input type="text" name="NOldStopNumb" id="IOldStopNumb">
                            <input type="text" name="NOper" id="IOper2">
                        </div>
                    </form>
                </td>
            </tr>
        </table>

</body>
<script>
    var CurRow = 0;
    // Добавлен участок
    var CurRow2 = 0; // Текущая строка таблицы маршруты на остановке
    SelectStopInRoute(1); // Функция сформирует таблицу маршруты на остановке
    var Table3 = document.getElementById("table3");
    // Конец добавленного участка
    var Table2 = document.getElementById("table2");
    var CurTR = Table2.rows[1];
    CurTR.style.backgroundColor = "#00ffff";

    //Изменение типа траспортного средства
    function change_select_transport_type() {
        xmlHttp = CreateAJAX();
        xmlHttp.onreadystatechange = ReceiveRequestForSelectTypeTransport;
        var Type = document.getElementById("IType");
        p = "SelectTypeTransport.php?Type=" + Type.value;
        xmlHttp.open("GET", p, true);
        xmlHttp.send(null);
    }//change_select_transport_type

    function TRClick(i) {
        CurTR = Table2.rows[CurRow + 1];
        CurTR.style.backgroundColor = "#ffffff";
        CurRow = i;
        CurTR = Table2.rows[CurRow + 1];
        CurTR.style.backgroundColor = "#00ffff";
        // Добавлена строчка сформирования таблицы остановки на маршруте
        SelectStopInRoute(CurTR.cells[0].innerHTML);
    } // end of TRClick

    function InsertClick() {
        var F1 = document.getElementById("form_stop");
        F1.hidden = false;
        document.getElementById("INameStop").value = "";
        var Oper = document.getElementById("IOper");
        Oper.value = 1;
    } // InsertClick

    function CancelClick() {
        var F1 = document.getElementById("form_stop");
        F1.hidden = true;
        var IOK = document.getElementById("IOK");
        IOK.value = "   ОК   ";
    } // End of CancelClick

    function UpdateClick() {
        var F1 = document.getElementById("form_stop");
        F1.hidden = false;
        Table2 = document.getElementById("table2");
        CurTR = Table2.rows[CurRow + 1];
        var td0 = CurTR.cells[0];
        var ID = td0.innerHTML;
        var td1 = CurTR.cells[1];
        var Name = td1.innerHTML;
        var td2 = CurTR.cells[2];
        var INameStop = document.getElementById("INameStop");
        INameStop.value = Name;
        var IID = document.getElementById("IID");
        IID.value = ID;
        var IOK = document.getElementById("IOK");
        IOK.value = "   ОК   ";
        var Oper = document.getElementById("IOper");
        Oper.value = 2;
    } // UpdateClick

    function DeleteClick() {
        UpdateClick();
        var IOK = document.getElementById("IOK");
        IOK.value = "Подтвердите удаление";
        var Oper = document.getElementById("IOper");
        Oper.value = 3;
    } // End of

    // Добавлены функции SelectStopInRoute, ReceiveRequest, TRClick2, PreEdit, InsertClick2, CancelClick2, UpdateClick2, DeleteClick2, CreateAJAX
    function SelectStopInRoute(Stop_ID) {
        xmlHttp = CreateAJAX();
        xmlHttp.onreadystatechange = ReceiveRequest;
        p = "SelectStop.php?Stop_ID=" + Stop_ID;
        //alert(p);
        xmlHttp.open("GET", p, true);
        xmlHttp.send(null);
    } // End of SelectStopInRoute

    function ReceiveRequest() {
        var TextDoc = null;
        if (xmlHttp.readyState == 4) {
            if (xmlHttp.status == 200) {
                TextDoc = xmlHttp.responseText;
                document.getElementById("table3").innerHTML = TextDoc;
                //CurTR2 = 0;
                TRClick2(0);
            } else {} // else
        } //if
    } // ReceiveRequest

    function ReceiveRequestForSelectTypeTransport() {
        var TextDoc = null;
        if (xmlHttp.readyState == 4) {
            if (xmlHttp.status == 200) {
                TextDoc = xmlHttp.responseText;
                document.getElementById("IRouteID").innerHTML = TextDoc;
                IRouteID = document.getElementById("IRouteID");
            } else {} // else
        } //if
    } // ReceiveRequestForSelectTypeTransport

    function TRClick2(i) {
        if (Table3.rows.length > 0) {
            //Предедущая активная строка становиться белой
            CurTR2 = Table3.rows[Number(CurRow2) + 1];
            CurTR2.style.backgroundColor = "#ffffff";
            //Текущая активная строка становиться выделенной
            CurRow2 = i;
            CurTR2 = Table3.rows[Number(CurRow2) + 1];
            CurTR2.style.backgroundColor = "#ffff00";
        } // if
    } // end of TRClick

    function PreEdit() {
        var F21 = document.getElementById("IStopNumb");
        F21.hidden = false;
        var Table2 = document.getElementById("table2");
        var Table3 = document.getElementById("table3");
        var CurTR = Table2.rows[CurRow + 1];
        var CurTR2 = Table3.rows[CurRow2 + 1];
        var td0 = CurTR.cells[0];
        var Stop_ID = td0.innerHTML;
        var IStopID = document.getElementById("IStopID");
        IStopID.value = Stop_ID.replace(/\s/g, ''); // Присвоить строку без пробелов
    } // End of PreEdit

    function InsertClick2() {
        PreEdit();
        var form_route = document.getElementById("form_route");
        form_route.hidden = false;
        var Oper2 = document.getElementById("IOper2");
        Oper2.value = 1;
    } // End of InsertClick

    function CancelClick2() {
        var form_route = document.getElementById("form_route");
        form_route.hidden = true;
        var IOK2 = document.getElementById("IOK2");
        IOK2.value = "   ОК   ";
    } // End of CancelClick

    function UpdateClick2() {
        PreEdit();
        var form_route = document.getElementById("form_route");
        form_route.hidden = false;
        Table3 = document.getElementById("table3");
        CurTR2 = Table3.rows[CurRow2 + 1];
        var td02 = CurTR2.cells[0];
        var Route_ID = td02.innerHTML;
        var td12 = CurTR2.cells[1];
        var StopNumb = td12.innerHTML;
        var cellType = CurTR2.cells[2];
        var Type = cellType.innerHTML;
        var IType = document.getElementById("IType");
        IType.value = Type;
        change_select_transport_type();
        var IStopNumb = document.getElementById("IStopNumb");
        IStopNumb.value = StopNumb;
        var IOldRouteID = document.getElementById("IOldRouteID");
        IOldRouteID.value = Route_ID;
        var IOldStopNumb = document.getElementById("IOldStopNumb");
        IOldStopNumb.value = StopNumb;
        var IRouteID = document.getElementById("IRouteID");
        //Через 100 мс присвоить списку номеров выбранный номер
        setTimeout(() => {
            IRouteID.value = Route_ID;
        }, 100);

        var IOK2 = document.getElementById("IOK2");
        IOK2.value = "   ОК   ";
        var Oper2 = document.getElementById("IOper2");
        Oper2.value = 2;
    } // UpdateClick

    function DeleteClick2() {
        UpdateClick2();
        var form_route = document.getElementById("form_route");
        form_route.hidden = false;
        var IOK2 = document.getElementById("IOK2");
        IOK2.value = "Подтвердите удаление";
        var Oper2 = document.getElementById("IOper2");
        Oper2.value = 3;
    } // End of DeleteClick2

    function CreateAJAX() {
        var xmlHttp;
        try {
            xmlHttp = new XMLHttpRequest();
        } catch (e) {
            try {
                xmlHttp = new ActiveXObject("MSXML2.XMLHTTP");
            } catch (e) {
                try {
                    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {} // catch
            } // catch
        } // catch
        if (!xmlHttp) {
            alert("Не удалось создать объект XMLHttpRequest");
        } // if
        return xmlHttp;
    } // CreateAJAX
</script>

</html>