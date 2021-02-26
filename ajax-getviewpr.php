<?php
require_once 'core/init.php';


if(isset($_POST['vrewardID'])){


  $id = $_POST['vrewardID'];
  $rewuser = new Preward();
  $row = $rewuser->searchRewardID($id);

  $array = [
  	"rewardID" => $row->rewardID,
  	"reward" => $row->reward,
  	"quantity" => $row->quantity,
  	"points" => $row->points
  ];

  echo json_encode($array);
}