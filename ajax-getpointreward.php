  
<?php
require_once 'core/init.php';


if(isset($_POST['rewardID'])){


  $id = $_POST['rewardID'];
  $rewuser = new Preward();
  $row = $rewuser->searchRewardID($id);

  $array = [
  	"rewardID" => $row->rewardID,
  	"reward" => $row->reward,
  	"description" => $row->description,
  	"rewardLimit" => $row->rewardLimit,
  	"points" => $row->points,
  	"category" => $row->category,
  	"expiredate" => $row->expiredate,
  	"entrydate" => $row->entrydate,
  	"quantity" => $row->quantity,
  	"companyID" => $row->companyID,
  ];
  echo json_encode($array);
  




}