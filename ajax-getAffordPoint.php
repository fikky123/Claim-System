<?php
require_once 'core/init.php';


if(isset($_POST['Apoint'])){

  $user = new User();
  $resultresult = $user->data();
  $userID = $resultresult->userID;
  $rewuser = new Preward();
  
  $corporateID = $resultresult->corporateID;
  $companyID = $resultresult->companyID;

  $id = $_POST['Apoint'];
if (empty($resultresult->corporateID) || $resultresult->corporateID == 0) {
    $idfrom2 = 'companyID';
    
    $row= $rewuser->searchmreward($resultresult->companyID, 'companyID');
}
else {
    $idfrom2 = 'corporateID';
    $row= $rewuser->searchmreward($resultresult->corporateID, 'corporateID');

}
    $point = $rewuser->searchPointReward($userID);

  
  $view = ' ';
  
 
                     if (empty($point)){
                  $view .= 'You have no reward currently';
                        }
                    else {
                      foreach ($point as $p){
                        if ($row){
                      foreach ($row as $key) {
                    if ($key->points <= $p->currentpoint){
                            
                        $view .= '<div class="col-sm-4 col-lg-3 col-md-3">
                          
                          <div class="card" style="border:1px solid #ccc; border-radius:5px; padding:16px; margin-bottom:16px; ">
                            <!-- <div class="px-2 btn btn-outline-danger btn-sm text-uppercase" style="width: 120px; font-size: 14px;font-weight: 900;left: 13px;top: 15px;position: absolute;background: white;" >
                            </div> --> ';
                            
                            if (empty($key->reward_img)){
                              $view .='<div class="d-flex card-img-top"><img src="img/nopicture.png" width="180" height="200"  alt="Reward Picture" class="rewardimg"></div>';}
                              else {
                                $view .= '<div class="d-flex card-img-top"><img src="data:image/jpeg;base64,'.base64_encode($key->reward_img).'" width="180" height="200" alt="Reward Picture" class="rewardimg"></div>'; }

                              $view .= '<div class="card-body">
                                <h5 class="card-title">
                                  <span class="badge badge-success">'
                                     .$key->category.'</span>
                                  <strong>'.$key->reward.'</strong>
                                </h5>
                                <p class="card-text">
                                <span class="badge badge-pill badge-warning"> P </span>'
                                   .$key->points.'<br>'
                                   .$key->description.'<br>
                                  Valid til:'.$key->expiredate.
                                '</p>';

                              
                              
                              $expdate = $key->expiredate;
                              $entrydate = $key->entrydate;
                              $uid = $rewuser->searchAllClaim5($key->rewardID, $userID);
                              date_default_timezone_set('Asia/Kuala_Lumpur');
                              $today = date('Y-m-d H:i:s');
                              
                              if (empty($uid)){ //check $count
                                $count = 0;
                               }
                              else{
                               $count = count($uid);
                               }

                              if ($expdate < $today){
                                 $view .= '<button type="button" class="btn btn-outline-danger pull-right" disabled>Expired</button>';
                               }

                              elseif ($key->quantity == 0 || $entrydate > $today){
                                $view .= '<button type="button" class="btn btn-outline-danger pull-right" disabled>Unavailable</button>';
                               }

                              elseif ($count == $key->rewardLimit){
                                  $view .= '<button type="button" class="btn btn-outline-danger pull-right" disabled>Reach Limit</button>';
                                 }
                               else {
                                $view .=  '<button type="button" class="btn btn-primary pull-right viewreward" data-toggle="modal" data-target="#viewreward" data-backdrop="static" id="'.$key->rewardID.'">Claim</button>';
                                 }
                               
                                $view .= '
                              </div>
                          </div>
                        </div>';

                      }   
             }
           }

         }
       }

      
  


  $array = ['view' => $view,
  ];

  echo ($view);
  

}