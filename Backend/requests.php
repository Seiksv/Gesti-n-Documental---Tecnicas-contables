<?php
require_once './config.php';

function getAllEmployeesdb(){
    $query="SELECT * FROM employee";
    if($result = db::getInstance()->get_results($query)){
        return $result;
    } else {
        return false;
    }
}

function getEmployeedb($dui){
    $query="SELECT * FROM employee where dui = '$dui'";
    if($result = db::getInstance()->get_results($query)){
        return $result;
    } else {
        return false;
    }
}

function getPaymentdb($dui){
    $query="SELECT * FROM payment inner join employee ON employee.dui = payment.dui where employee.dui = '$dui'";
    if($result = db::getInstance()->get_results($query)){
        return $result;
    } else {
        return false;
    }
}
