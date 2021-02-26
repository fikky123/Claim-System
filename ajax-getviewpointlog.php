 <?php
require_once 'core/init.php';
$user = new User();
if(!$user->isLoggedIn()){
  Redirect::to("login.php");
}else{
  $resultresult = $user->data();
  $userlevel = $resultresult->role;
  if($resultresult->verified == false || $resultresult->superadmin == true){
    $user->logout();
    Redirect::to("login.php");
  }
}

  $reward = new Preward();

  $apuserID = escape(Input::get('apuserID'));

  // $id = $user->data()->userID;
  
  $s = $reward->searchpointlog($apuserID);
    
    $view ="";
    
    if (empty($s)){
      $view .='<div>Nothing to show</div>';
    }
    
    if($s){
      foreach ($s as $row1) {
        // $userresult1 = $user->searchOnly($row1->userID);
        $view .=
        "<li class='list-group-item list-group-item-action' id='try'>
            <div>".$row1->action_name."<span class='float-right'>".$row1->actionDate."</span></div>
            <div><small>Description: ".$row1->description."</small></div>
        </li>";
        }
    }

      

    $array = [
     
        "apuserID" => $apuserID,
        "view" => $view,
      ];

  echo json_encode($array);

?>
