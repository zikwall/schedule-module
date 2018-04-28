<?php
$db = mysql_connect('localhost', 'root', '', 'db1') or die('Ошибка подключения к БД');

if (isset($_POST["name"]) && isset($_POST['email'])){

    $result=mysql_query("UPDATE `table3` SET `name` = '$name', `email` = '$email' WHERE `id`= $id_bileta");

    //print_r($_POST);

    echo $result ? 'Информация в базу добавлена' : 'Информация в базу НЕ добавлена';

    /*if ($result) {
        echo "Информация в базу добавлена";

    } else {
        echo "Информация в базу НЕ добавлена";
    }*/

} else {
    echo 'All fields are required!';
}
