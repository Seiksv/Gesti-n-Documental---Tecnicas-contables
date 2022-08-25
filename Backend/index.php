<?php
  header('Access-Control-Allow-Origin: *');
  header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

  require_once './requests.php';
  require_once './response.php';
  require_once './constants.php';



  if (isset($_REQUEST['function']))
  {
      if (function_exists($_REQUEST['function'])) $_REQUEST['function']($_REQUEST);
  }


  function getAllEmployees($arguments=array()) {

    if($textBlock =  getAllEmployeesdb()) {


            echo  returnDataToCLient(SUCCESS_STATE,OK,"Show",null,$textBlock);
    }else{
            echo  returnDataToCLient(ERROR_STATE,INTERNAL_SERVER_ERROR,"No data was retrieve",null,$textBlock);
     }
  }


  function getEmployee($arguments=array()) {
    if(!isset($arguments['dui'])){
        echo  returnDataToCLient(ERROR_STATE,INTERNAL_SERVER_ERROR,"Missing field DUI",null,"");
        return;
    }

    $dui      = $arguments['dui'];


    if($textBlock =  getEmployeedb($dui)) {
            echo  returnDataToCLient(SUCCESS_STATE,OK,"Show",null,$textBlock);
    }else{
            echo  returnDataToCLient(ERROR_STATE,INTERNAL_SERVER_ERROR,"No data was retrieve",null,$textBlock);
     }
  }

  function getPayment($arguments=array()) {
    if(!isset($arguments['dui'])){
        echo  returnDataToCLient(ERROR_STATE,INTERNAL_SERVER_ERROR,"Missing field DUI",null,"");
        return;
    }
    
    $dui      = $arguments['dui'];

    if($textBlock =  getPaymentdb($dui)) {
        $hiringDate = $textBlock["hiringDate"];
        $ISSS = 0;
        $AFP = 0;
        $revenue = 0;
        $allSalary = 0;
        $bonus = 0;
        $taxedBonus = 0;
        $nonTaxedBonus = 0;
        $ISSStemp =0;
        
         foreach ($textBlock as $key => $value) {

            if($value["paymentType"] == 1){
                $bonus += $value["amount"];
            }
            if($value["paymentType"] == 2){
                $taxedBonus = $value["amount"];
            }
        }


        // ISSS
        for ($i=0; $i < 11; $i++) { 
            $ISSStemp = $key["salary"] * 0.03;
            $ISSS += $ISSStemp > 30 ? 30 : $ISSStemp;
        }

        //Por si existe un bono de vacaciones
        $ISSStemp = ($key["salary"] + $bonus) * 0.03;
        $ISSS += $ISSStemp > 30 ? 30 : $ISSStemp;

        //AFP
        for ($i=0; $i < 11; $i++) { 
            $AFPtemp = $key["salary"] * 0.0725;
            $AFP += $AFPtemp > 7045.06 ? 7045.06 : $AFPtemp;
        } 
         //Por si existe un bono de vacaciones
         $AFPtemp = ($key["salary"] + $bonus) * 0.0725;
         $AFP += $AFPtemp > 7045.06 ? 7045.06 : $AFPtemp;
 


         // Validacion aguinaldo grabado o no grabado
        if ($taxedBonus > 1100) {
            $taxedBonus -= 1100;
            $nonTaxedBonus = 1100;
        } else {
            $nonTaxedBonus = $taxedBonus;
        }

        // Renta
        $allSalary = ($key["salary"] * 12 ) + $bonus + $taxedBonus;

        if ($allSalary >= 0.01 && $allSalary <= 4064.00) {
            $revenue = 0;
        } else if ($allSalary >= 4064.01 && $allSalary <= 9142.86) { 
            $revenue = (($allSalary - 4064.01) * 0.1) + 212.12;
        } else if ($allSalary >= 9142.87 && $allSalary <= 22857.14) { 
            $revenue = (($allSalary - 9142.87) * 0.2) + 720.00;
        } else if ($allSalary >= 22857.15) { 
            $revenue = (($allSalary - 22857.15) * 0.3) + 3462.86;
        }


        $result["employeeName"] = $textBlock["name"];
        $result["taxedBonus"] = $taxedBonus;
        $result["nonTaxedBonus"] = $nonTaxedBonus;
        $result["anualIncomes"] = $allSalary;
        $result["ISSS"] = $ISSS;
        $result["AFP"] = $AFP;
        $result["revenue"] = $revenue;


            echo  returnDataToCLient(SUCCESS_STATE,OK,"Show",null,$textBlock);
    }else{
            echo  returnDataToCLient(ERROR_STATE,INTERNAL_SERVER_ERROR,"No data was retrieve",null,$textBlock);
     }
  }

  

  