<?php
//загрузка приложения
require_once "application/model/GBModel.php";
require_once "application/view/GBView.php";
require_once "application/controller/GBController.php";

//запуск контроллера
$gb = new GBController();
$gb->index();

?>