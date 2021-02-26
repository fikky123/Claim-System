<?php
require_once 'core/init.php';


if(isset($_POST['pointID'])){


  $id = $_POST['pointID'];
  $rewuser = new Preward();
  $row = $rewuser->searchPointReward4($id);

  $array = [
  	"pointID" => $row->pointID,
  	// "currentpoint" => $row->currentpoint,
  	"totalpoint" => $row->totalpoint,
  	"userID" => $row->userID,
    "companyID" => $row->companyID,
   ];
  echo json_encode($array);
}