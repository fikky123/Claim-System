<?php
require_once 'core/init.php';

 
if(isset($_POST['apuserID']) && isset($_POST['catlog'])){

  $user = new User();
  $resultresult = $user->data();
  $userID = $resultresult ->userID;
  $rewuser = new Preward();
  
  $corporateID = $resultresult->corporateID;
  $companyID = $resultresult->companyID;

 
  $apuserID = escape(Input::get('apuserID'));

  $id2 = $_POST['catlog'];
  if ($id2==="allhistory"){
    $row = $rewuser->searchpointlog($apuserID);
  }
  else {   
    $row = $rewuser->getCategorylog($apuserID, $id2);
  }
  
  $view=" ";
    
    if (empty($row)){
      $view .='<div>Nothing to show</div>';
    }

    if($row){
      foreach ($row as $row2) {
        // $userresult1 = $user->searchOnly($row1->userID);
        $view .=
        "<li class='list-group-item list-group-item-action'>
            <div>".$row2->action_name."<span class='float-right'>".$row2->actionDate."</span></div>
            <div><small>Description: ".$row2->description."</small></div>
        </li>
        ";
      }
    }
    

    $array = [
     
        // "apuserID" => $apuserID,
        "view" => $view,
      ];

  echo json_encode($array);
  

// echo($viewlog);
}