<?php
require_once 'core/init.php';
$user= new User();
if(!$user->isLoggedIn()){
  Redirect::to("login.php");
}else{
  $resultresult = $user->data();
  $userlevel = $resultresult->role;
  if($resultresult->verified == false || $resultresult->superadmin == true){
    $user->logout();
    Redirect::to("login.php?error=error");
  }
}

$company2 = new Company();
$reward = new Preward();
$kpireward = new Rewards();
$user = new User();

if (empty($resultresult->corporateID) || $resultresult->corporateID == 0) {
    $checkid2 = $resultresult->companyID;
    $idfrom2 = 'companyID';
    $claimresult= $reward->searchAllComClaim($checkid2);
}
else {
    $checkid2 = $resultresult->corporateID;
    $idfrom2 = 'corporateID';
    $claimresult= $reward->searchAllCorClaim($checkid2);
}

$view = '';

                   if($claimresult){       
                      $view .='<table class="table table-responsive-sm table-sm my-3">
                            <thead>
                              <th>Name</th>
                              <th>Reward</th>
                              <th>Date Claimed</th>
                              <th>Status</th>
                            </thead>
                            <tbody>';

                    foreach ($claimresult as $key) {
                      $userresult =$user->searchUser($key->userID); 
                      $rewardr = $reward->searchRewardID($key->rewardID);                            
                            $view .='
                              <tr>
                                <td>'.$userresult->firstname.' '.$userresult->lastname.'</td>
                                <td>'.$rewardr->reward.'</td>
                                <td>'.$key->date.'</td>
                                <td>';
                                  
                             if($key->status == "Received"){
                                $view .= '<button type="button" class="btn btn-outline-primary text-dark" disabled>Received</button>';} 
                              else{
                                $view .= '<button type="button" class="btn btn-primary receivereward" data-toggle="modal" data-target="#receivereward" data-backdrop="static" id="'.$key->claim_rewardID.'">Pending</button>';
                                    }
                                    
                            $view .='         
                                </td>
                              </tr>';
                           
                    } 
                  }
                    else{
                      $view .= '<p class="text-center">Nothing to show</p>';
                            }
                  $view .='
                               </tbody>
                          </table>';

echo ($view);
?>
          


