<?php
require_once 'core/init.php';


if(isset($_POST['cat'])){

  $user = new User();
  $resultresult = $user->data();
  
  $rewuser = new Preward();
  $userID = $resultresult ->userID;
  $corporateID = $resultresult->corporateID;

  $id = $_POST['cat'];
  if ($id==="all2"){
      $row = $rewuser->getclaimreward($userID);

  }
  else {
    $row = $rewuser->getusercategoryclaimed($userID,$id);
  }
  
  $view = ' ';

   if ($row){
                                
  foreach ($row as $key1) {
                            
  $view .= '<div class="col-sm-4 col-lg-3 col-md-3">
                          
                          <div class="card" style="border:1px solid #ccc; border-radius:5px; padding:16px; margin-bottom:16px; ">
                            <!-- <div class="px-2 btn btn-outline-danger btn-sm text-uppercase" style="width: 120px; font-size: 14px;font-weight: 900;left: 13px;top: 15px;position: absolute;background: white;" >
                            </div> --> ';
                            
  if (empty($key1->reward_img)){
      $view .='<div class="d-flex card-img-top"><img src="img/nopicture.png" width="200" height="200" style="object-fit: contain;display: flex;overflow: auto;" alt="Reward Picture" class="product"></div>';}
  else {
      $view .= '<div class="d-flex card-img-top"><img src="data:image/jpeg;base64,'.base64_encode($key1->reward_img).'" width="200" height="200" style="object-fit: contain;display: flex; overflow: auto;" alt="Reward Picture" class="product"></div>'; }

      $view .= '<div class="card-body">
                                <h5 class="card-title">
                                  <span class="badge badge-success">'
                                     .$key1->category.'</span>
                                  <strong>'.$key1->reward.'</strong>
                                </h5>
                                <p class="card-text">
                                <span class="badge badge-pill badge-warning"> P </span>'
                                   .$key1->points.'<br>'
                                   .$key1->description.'<br>
                                  Valid til:'.$key1->expiredate.
                                '</p>
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