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

$reward = new Preward();
$userID = $resultresult->userID;

if (empty($resultresult->corporateID) || $resultresult->corporateID == 0) {
  $checkid2 = $resultresult->companyID;
    $idfrom2 = 'companyID';
    
    $rewardresult= $reward->searchAllReward($resultresult->companyID, 'companyID');
}
else {
  $checkid2 = $resultresult->corporateID;
    $idfrom2 = 'corporateID';
    $rewardresult= $reward->searchAllReward($resultresult->corporateID, 'corporateID');

}

 $view = ' ';
       
                                if($rewardresult){
                                  $view .='
                              <table class="table table-responsive-sm table-sm my-3 text-center">
                                <thead>
                                  <tr>
                                    <th> </th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Quantity</th>
                                    <th>Limit (Per Person)</th>
                                    <th>Point</th>
                                    <th>Category</th>
                                    <th>Deadline</th>
                                    <th>Date Entry</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody>';
                   
                                foreach ($rewardresult as $row) {
                          $view .='
                                  <tr>
                                    <td>';
                                      if (empty($row->reward_img)){
                                      $view .='<img src="img/nopicture.png" width="150" height="150" style="object-fit: cover;" alt="Reward Picture">';}
                                      else {
                                      $view .='<img src="data:image/jpeg;base64,'.base64_encode($row->reward_img).'" width="150" height="150" style="object-fit: contain;" alt="Reward Picture">';} 
                                      $view .='</td>
                                    <td class="align-middle">'.$row->reward.'</td>
                                    <td class="align-middle">'.$row->description.'</td>
                                    <td class="align-middle">'.$row->quantity.'</td>
                                    <td class="align-middle">'.$row->rewardLimit.' time</td>
                                    <td class="align-middle">'.$row->points.' pts</td>
                                    <td class="align-middle">'.$row->category.'</td>
                                    <td class="align-middle">'.$row->expiredate.'</td>
                                    <td class="align-middle">'.$row->entrydate.'</td>';
                                    if ($row->userID == $userID){
                                    $view .= '<td class="align-middle"><a class="btn btn-white btn-sm editbutton" data-toggle="modal" data-target="#editpreward" data-backdrop="static" id="'.$row->rewardID.'"><i class="fas fa-edit text-success"></i></a>
                                        <a class="btn btn-white btn-sm deletebutton" data-toggle="modal" data-target="#removepreward" data-backdrop="static" id="'.$row->rewardID.'"><i class="fas fa-remove text-danger"></i></a></td>
                                      </tr>';}
                                      else{
                                        $view .= '<td class="align-middle"><a class="btn btn-white btn-sm text-muted"><i class="fas fa-edit"></i></a>
                                        <a class="btn btn-white btn-sm text-muted"><i class="fas fa-remove"></i></a></td>
                                      </tr>';
                                      }
                              
                                }
                              $view .='
                              </tbody>
                            </table>
                          </div>';
            }
            else{
            $view .='
            <div class="col">
              <p class="text-center">Nothing to show</p>
          </div>

            ';
            }

              echo ($view);
            ?>

