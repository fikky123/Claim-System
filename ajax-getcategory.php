<?php
require_once 'core/init.php';


if(isset($_POST['category'])){

  $user = new User();
  $resultresult = $user->data();
  $userID = $resultresult ->userID;
  $rewuser = new Preward();
  
  $corporateID = $resultresult->corporateID;
  $companyID = $resultresult->companyID;

  $id = $_POST['category'];
  if ($id==="all"){
    if (empty($resultresult->corporateID) || $resultresult->corporateID == 0) {
        $row= $rewuser->searchmreward($resultresult->companyID, 'companyID');
    }
    else {
    $row= $rewuser->searchmreward($resultresult->corporateID, 'corporateID');
    }
  }
  else {   
    if (empty($resultresult->corporateID) || $resultresult->corporateID == 0) {
        $row = $rewuser->getCategory($resultresult->companyID, 'companyID', $id);
    }
    else {
        $row = $rewuser->getCategory($resultresult->corporateID, 'corporateID', $id);
    }
  }
  
  $view = ' ';
  
                              if(empty($row)){
                                $view .= 'You have no reward currently';
                              } 

                               elseif ($row){
                                
                              foreach ($row as $row1) {
                              date_default_timezone_set('Asia/Kuala_Lumpur');
                              $today = date('Y-m-d H:i:s');
                            
                        $view .= '<div class="col-sm-4 col-lg-3 col-md-3">
                          
                          <div class="card" style="border:1px solid #ccc; border-radius:5px; padding:16px; margin-bottom:16px; ">
                            <!-- <div class="px-2 btn btn-outline-danger btn-sm text-uppercase" style="width: 120px; font-size: 14px;font-weight: 900;left: 13px;top: 15px;position: absolute;background: white;" >
                            </div> --> ';
                            
                            if (empty($row1->reward_img)){
                              $view .='<div class="d-flex card-img-top"><img src="img/nopicture.png" width="180" height="200" alt="Reward Picture" class="rewardimg"></div>';}
                              else {
                                $view .= '<div class="d-flex card-img-top"><img src="data:image/jpeg;base64,'.base64_encode($row1->reward_img).'" width="200" height="180" alt="Reward Picture" class="rewardimg"></div>'; }

                              $view .= '<div class="card-body">
                                <h5 class="card-title">
                                  <span class="badge badge-success">'
                                     .$row1->category.'</span>
                                  <strong>'.$row1->reward.'</strong>
                                </h5>
                                <p class="card-text">
                                <span class="badge badge-pill badge-warning"> P </span>'
                                   .$row1->points.'<br>'
                                   .$row1->description.'<br>
                                  Valid til:'.$row1->expiredate.
                                '</p>';

                              
                              
                              $expdate = $row1->expiredate;
                              $entrydate = $row1->entrydate;
                              $uid = $rewuser->searchAllClaim5($row1->rewardID, $userID);
                              
                              
                              if (empty($uid)){ //check $count
                                $count = 0;
                               }
                              else{
                               $count = count($uid);
                               }

                              if ($expdate < $today){
                                 $view .= '<button type="button" class="btn btn-outline-danger pull-right" disabled>Expired</button>';
                               }

                              elseif ($row1->quantity == 0 || $entrydate > $today){
                                $view .= '<button type="button" class="btn btn-outline-danger pull-right" disabled>Unavailable</button>';
                               }

                              elseif ($count == $row1->rewardLimit){
                                  $view .= '<button type="button" class="btn btn-outline-danger pull-right" disabled>Reach Limit</button>';
                                 }

                               else {
                                $view .=  '<button type="button" class="btn btn-primary pull-right viewreward" data-toggle="modal" data-target="#viewreward" data-backdrop="static" id="'.$row1->rewardID.'">Claim</button>';
                                 }
                               
                                $view .= '
                              </div>
                          </div>
                        </div>';

                          
             }
           }
                  
                    
     

  else {
    $view .= 'You have no reward currently';
  }

  $array = ['view' => $view,
  ];

  echo ($view);
  

}