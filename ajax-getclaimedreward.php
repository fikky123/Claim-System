<?php
require_once 'core/init.php';


if(isset($_POST['claimID'])){


  $id = $_POST['claimID'];
  $rewuser = new Preward();
  $row = $rewuser->searchAllClaim3($id);

  $array = [
  	"claim_rewardID" => $row->claim_rewardID,
  	"status" => $row->status,
  	"companyID" => $row->companyID,
  ];
  echo json_encode($array);
}