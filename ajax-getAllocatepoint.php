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
$user = new User();

if (empty($resultresult->corporateID) || $resultresult->corporateID == 0) {
    $checkid2 = $resultresult->companyID;
    $idfrom2 = 'companyID';
    $companyresult = $company2->searchCompany($checkid2);
    $allcompany = $companyresult;
}
else {
  $checkid2 = $resultresult->corporateID;
    $idfrom2 = 'corporateID';
    $companyresult = $company2->searchCompany($checkid2);
    $allcompany = $company2->searchCompanyCorporate($checkid2);
}

$view=' ';
              
              if($allcompany){
                foreach ($allcompany as $row) {                             
                $view .='<div class="row mb-3">

                <br>   
                  <h6><button class="btn btn-sm btn-link" data-toggle="collapse" data-target="#company'.$row->companyID.'" aria-expanded="false" aria-controls="company'.$row->companyID.'"><i class="fas fa-caret-down"></i></button>'.$row->company.'</h6>
              
                <br>

                <div class="container-fluid">
                  <div class="collapse multi-collapse" id="company'.$row->companyID.'">
                   <table class="table table-responsive-sm table-sm my-3">  
                     
                                <thead>
                                  <tr>
                                    <th>Name</th>
                                    <th>Current Point</th>
                                    <th class="text-right">Action</th>
                                  </tr>
                                </thead>
                                <tbody>';
                                
                                  $point = $reward->searchPointComReward($row->companyID);
                              
                                if (empty($point)){
                                  $view .='<tr><td colspan="3" class="text-center">Nothing to show</td></tr>';
                                }

                                  else{
                                    foreach($point as $key){
                                  $userresult =$user->searchUser($key->userID);
                                  $view .='
                                  <tr>  
                                    <td>';
                                    if (empty($userresult->profilepic)){
                                    $view .='<div class="d-flex card-img-top"><img src="img/userprofile.png" class="mr-1 rounded-circle" style="width:30px;height: 30px;">'.$userresult->firstname.' '.$userresult->lastname.'</td>';}
                                    else {
                                    $view .='<div class="d-flex card-img-top "></div><img src="data:image/jpeg;base64,'.base64_encode($userresult->profilepic).'" class="mr-1 rounded-circle" style="width:30px;height: 30px;">'.$userresult->firstname.' '.$userresult->lastname.'</td>';}
                                    $view .='
                                    <td>'.$key->currentpoint.'</td>
                                    <td class="text-right"><a class="btn btn-white btn-sm editpointall" data-toggle="modal" data-target="#editpoint" data-backdrop="static" id="'.$key->pointID.'"><i class="fas fa-edit"></i></a> 
                                    <a class="btn btn-white btn-sm pointlogview" data-toggle="modal" data-target="#pointlogview" data-backdrop="static" id="'.$key->userID.'"><i class="fas fa-history"></i></a></td> 
                                  </tr>';
                                  } // foreach scoreresult
                                  } //tutup if scoreresult
                                $view .='
                              </tbody>
                            </table>
                          </div> <!-- collapse multi-collapse-->
                        </div>
                      </div> <!-- tutup row mb-3 --> 
                      ';

                } //tutup foreach allcompany
        
            } //tutup if allcompany
          
            else{
            $view .='
            <div class="card my-3 shadow-sm p-2 text-center">
              <i class="far fa-building my-3" style="font-size:40px;"></i>
              <h5>'.$array['nocompanyfound'].'</h5>
              <p>'.$array['nocompanyfoundexplain'].'</p>
            </div>';
            }

$view .= "
<script type='text/javascript'>
  $('.categorylog').on('change', function(){
    var apuserID=$('#userid2').val();
    var catlog = $('.categorylog').val();

     console.log(apuserID);
    $.ajax({
      url:'ajax-getcatlog.php',
      method:'POST',
      data:{apuserID:apuserID,catlog:catlog},
      dataType:'json',
      success:function(data){
        console.log(data);
        $('#pointlogviews').html(data.view);
        $('#pform').modal({show:true});
      }
    });
    });
 </script>";
           echo ($view);
           ?>
