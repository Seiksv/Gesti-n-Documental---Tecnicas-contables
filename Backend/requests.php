<?php
require_once './config/db.php';

function getRebrandlyCustomDomain(){
    $query="select * from sprout_shortener_domain_tbl where provider = 4 and active = 1";
    if($result = db::getInstance()->get_results($query)){
        return $result;
    } else {
        return false;
    }
}
