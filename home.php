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
include 'include/header.php';

$id = $user->data()->userID;
$cid = $user->data()->companyID;

$reward = new Preward();
$kpireward = new Rewards();

if (empty($resultresult->corporateID) || $resultresult->corporateID == 0) {
    $checkid2 = $resultresult->companyID;
    $idfrom2 = 'companyID';
    
    $rewardresult= $reward->searchmreward($resultresult->companyID, 'companyID');
    // $kpirewardresult= $kpireward->AllRewards($checkid2);
    // $rewardresult3 = $reward->getclaimreward($checkid2);
}
else {
  $checkid2 = $resultresult->corporateID;
    $idfrom2 = 'corporateID';
    $rewardresult= $reward->searchmreward($resultresult->corporateID, 'corporateID');
    // $kpirewardresult= $kpireward->AllRewards($resultresult->corporateID);
    // $rewardresult3 = $reward->getclaimreward($resultresult->corporateID);

}

$rewardresult3 = $reward->getclaimreward($id);
$rewardresult2 = $reward->searchPointReward($id);
?>
<body>
<style>
  .rewardimg {
  object-fit: contain;
  display: block; 
  overflow: auto; 
  margin-left: auto;
  margin-right: auto;
}
</style>
  <div class="d-flex" id="wrapper">
    <?php include 'include/navbar.php';?>
    <div class="container-fluid">
     <h4 class="my-5"><i class='fas fa-gift'></i> Reward</h4>


                          <div class="row">
                            <div class="col">
                              <ul class="nav nav-pills" id="prewardtab">
                                <li class='nav-item'>
                                  <a class='nav-link active' data-toggle='tab' href='#allr'>All</a>
                                </li>
                                <li class='nav-item'>
                                  <a class='nav-link' data-toggle='tab' href='#claimed'>Claimed</a>
                                </li>
                                <li class='nav-item'>
                                  <a class='nav-link' data-toggle='tab' href='#expired'>Expired</a>
                                </li>
                              </ul>
                            </div>
                          </div>

                        <div class="container-fluid">
                          <div class="card-body">
                            <div class="tab-content">
                              <div class="tab-pane fade show active" id="allr">
                               <div class="row mb-3">
                                <div class="col text-right">
                                  <form>
                                    <input type="checkbox" id="affordpoint" data-id="<?php echo $checkid2?>"> Afford Point
                                    <select type="text" class="form-control-sm" id="category">
                                      <option type="text" value="all">All</option>
                                      <option type="text" value="Gift">Gift</option>
                                      <option type="text" value="Cash">Cash</option>
                                      <option type="text" value="Voucher">Voucher</option>
                                      <option type="text" value="Item">Item</option>
                                      <option type="text" value="Other">Other</option>
                                    </select>
                                  </form>
                                </div>
                            </div>

                      <div class="row px-sm-2 px-0" id="catdata">
                          <?php
                   if($rewardresult){
                              foreach ($rewardresult as $row) {
                              date_default_timezone_set('Asia/Kuala_Lumpur');
                              $today = date('Y-m-d H:i:s');
                            ?>
                        <div class="col-sm-4 col-lg-3 col-md-3">
                          
                          <div class="card" style="border:1px solid #ccc; border-radius:5px; padding:16px; margin-bottom:16px; ">
                            <?php
                            if (empty($row->reward_img)){
                              echo'<div class="d-flex card-img-top"><img src="img/nopicture.png" width="180" height="200"  alt="Reward Picture" class="rewardimg"></div>';}
                              else {?>
                                <div class="d-flex card-img-top "><img src="data:image/jpeg;base64,<?php echo base64_encode($row->reward_img);?>" width="180" height="200" alt="Reward Picture" class="rewardimg"></div><?php } ?>

                              <div class="card-body">
                                <h5 class="card-title">
                                  <span class='badge badge-success'>
                                    <?php echo $row->category;?>
                                  </span>
                                  <strong><?php echo $row->reward;?></strong>
                                </h5>
                                <p class="card-text">
                                <span class='badge badge-pill badge-warning'> P </span>
                                  <?php echo $row->points;?><br>
                                  <?php echo $row->description;?><br>
                                  Valid til: <?php echo $row->expiredate;?>
                                </p>

                                <?php
                              
                              $expdate = $row->expiredate;
                              $entrydate = $row->entrydate;
                              $uid = $reward->searchAllClaim5($row->rewardID, $id);
                              
                              
                              if (empty($uid)){ //check $count
                                $count = 0;
                               }
                              else{
                               $count = count($uid);
                               }

                               if ($expdate < $today){
                                 echo '<button type="button" class="btn btn-outline-danger pull-right" disabled>Expired</button>';
                               }

                              elseif ($row->quantity == 0 || $entrydate > $today){
                                echo '<button type="button" class="btn btn-outline-danger pull-right" disabled>Unavailable</button>';
                               }

                              elseif ($count == $row->rewardLimit){
                                  echo '<button type="button" class="btn btn-outline-danger pull-right" disabled>Reach Limit</button>';
                                 }

                              else {
                                echo '<button type="button" class="btn btn-primary pull-right viewreward" data-toggle="modal" data-target="#viewreward" data-backdrop="static" id="'.$row->rewardID.'">Claim</button>';
                                 }
                               
                                ?> 
                              </div>
                          </div>
                        </div>

                          <?php
                          }
                        }
                    else{
                    echo 'You have no reward currently';
                  }
                  
                  ?>
                      
                    </div>
                  </div>

                  <!--claimed-->
                              <div class="tab-pane fade" id="claimed">
                               <div class="row mb-3">
                                <div class="col text-right">
                                  <form>
                                    <select type="text" class="form-control-sm" id="category2">
                                      <option type="text" value="all2">All</option>
                                      <option type="text" value="Gift">Gift</option>
                                      <option type="text" value="Cash">Cash</option>
                                      <option type="text" value="Voucher">Voucher</option>
                                      <option type="text" value="Item">Item</option>
                                      <option type="text" value="Other">Other</option>
                                    </select>
                                  </form>
                                </div>
                            </div>
                             
                      <div class="row px-sm-2 px-0" id="catdata2">
                          <?php
                          if($rewardresult3){
                           foreach ($rewardresult3 as $row1) { ?> 
                       <div class="col-sm-4 col-lg-3 col-md-3">
                          
                          <div class="card" style="border:1px solid #ccc; border-radius:5px; padding:16px; margin-bottom:16px; ">
                            
                            <?php
                            if (empty($row1->reward_img)){
                              echo'<div class="d-flex card-img-top"><img src="img/nopicture.png" width="180" height="200" alt="Reward Picture" class="rewardimg"></div>';}
                              else {?>
                                <div class="d-flex card-img-top"><img src="data:image/jpeg;base64,<?php echo base64_encode($row1->reward_img);?>" width="180" height="200" alt="Reward Picture" class="rewardimg"></div><?php } ?>

                              <div class="card-body">
                                <h5 class="card-title">
                                  <span class='badge badge-success'>
                                    <?php echo $row1->category;?>
                                  </span>
                                  <strong><?php echo $row1->reward;?></strong>
                                </h5>
                                <p class="card-text">
                                <span class='badge badge-pill badge-warning'> P </span>
                                  <?php echo $row1->points;?><br>
                                  <?php echo $row1->description;?><br>
                                  Date Claimed: <?php echo $row1->date;?>
                                </p>
                            </div>
                          </div>
                        </div>
                        <?php
                  }
                }
                else{
                    echo 'You have no reward currently';
                  }
                  ?>
                      </div>
                    </div><!--claimed-->
                      
                    <div class="tab-pane fade" id="expired">
                               <div class="row mb-3">
                                <div class="col text-right">
                                  <form>
                                    <select type="text" class="form-control-sm" id="category3">
                                      <option type="text" value="all3">All</option>
                                      <option type="text" value="Gift">Gift</option>
                                      <option type="text" value="Cash">Cash</option>
                                      <option type="text" value="Voucher">Voucher</option>
                                      <option type="text" value="Item">Item</option>
                                      <option type="text" value="Other">Other</option>
                                    </select>
                                  </form>
                                </div>
                            </div>

                       <?php
                    if ($rewardresult){
                    ?>
                      <div class="row px-sm-2 px-0" id="catdata3">
                          <?php
                           foreach ($rewardresult as $row2) { 
                            $expdate = $row2->expiredate;
                            if ($expdate < $today){ ?> 
                       <div class="col-sm-4 col-lg-3 col-md-3">
                          
                          <div class="card" style="border:1px solid #ccc; border-radius:5px; padding:16px; margin-bottom:16px; ">
                            
                            <?php
                            if (empty($row2->reward_img)){
                              echo'<div class="d-flex card-img-top"><img src="img/nopicture.png" width="180" height="200" alt="Reward Picture" class="rewardimg"></div>';}
                              else {?>
                                <div class="d-flex card-img-top"><img src="data:image/jpeg;base64,<?php echo base64_encode($row2->reward_img);?>" width="180" height="200" alt="Reward Picture" class="rewardimg"></div><?php } ?>

                              <div class="card-body">
                                <h5 class="card-title">
                                  <span class='badge badge-success'>
                                    <?php echo $row2->category;?>
                                  </span>
                                  <strong><?php echo $row2->reward;?></strong>
                                </h5>
                                <p class="card-text">
                                <span class='badge badge-pill badge-warning'> P </span>
                                  <?php echo $row2->points;?><br>
                                  <?php echo $row2->description;?><br>
                                  Valid til: <?php echo $row2->expiredate;?>
                                </p>
                            </div>
                          </div>
                        </div>
                        <?php
                  }
                }
              }
              else{
                    echo 'You have no reward currently';
                  }
                  ?>
                      </div>
                    </div><!--Expired-->

                  </div>
                </div> 
              </div>

              </div><!--Point -->

            </div><!--tab content-->
          </div>
        </div>
</div>
            </body> 

    <!-- /#page-content-wrapper -->
<!-- <script type="text/javascript">
  $(document).ready(function(){
     $("#sidebar-wrapper .active").removeClass("active");
     $("#yourkpinavid").addClass("active");
  });
</script> -->

<script type="text/javascript">
$("body").on("click", ".viewreward", function(e){

e.preventDefault();
vrewardID=$(this).attr('id');
$.ajax({
    url: "ajax-getviewpr.php",
    type: "POST",
    data: {vrewardID:vrewardID},

    success:function(response){
    data = JSON.parse(response);
    
      $("#vrewardID").val(data.rewardID);
      $("#vpoints").val(data.points);
    }

  });

});

  $('#category').on('change', function(){

      var category = $('#category').val();
      //var All = $('#category').val('All');
      //var chartType = $('#chartType').val();
      //var myChart = document.getElementById('myChart').getContext('2d');
    $.ajax({
      url:"ajax-getcategory.php",
      method:"POST",
      data:{category:category},
      //dataType:"json",
      success:function(data){
        $("#catdata").html(data);
        console.log(data);
        //dataCategory = [data.gift, data.cash, data.voucher, data.item, data.other];
        //updateCat(dataCategory);
      }
    });
    });

      $(document).ready(function(){
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#reward a[href="' + activeTab + '"]').tab('show');
    }
    });

    $(document).ready(function(){
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#prewardtab a[href="' + activeTab + '"]').tab('show');
    }
    });

  $('#category2').on('change', function(){

      var cat = $('#category2').val();
      //var All = $('#category').val('All');
      //var chartType = $('#chartType').val();
      //var myChart = document.getElementById('myChart').getContext('2d');
    $.ajax({
      url:"ajax-getcatclaimed.php",
      method:"POST",
      data:{cat:cat},
      //dataType:"json",
      success:function(data){
        $("#catdata2").html(data);
        console.log(data);
        //dataCategory = [data.gift, data.cash, data.voucher, data.item, data.other];
        //updateCat(dataCategory);
      }
    });
    });

  $('#category3').on('change', function(){

      var catExp = $('#category3').val();
      //var All = $('#category').val('All');
      //var chartType = $('#chartType').val();
      //var myChart = document.getElementById('myChart').getContext('2d');
    $.ajax({
      url:"ajax-getcatExp.php",
      method:"POST",
      data:{catExp:catExp},
      //dataType:"json",
      success:function(data){
        $("#catdata3").html(data);
        console.log(data);
        //dataCategory = [data.gift, data.cash, data.voucher, data.item, data.other];
        //updateCat(dataCategory);
      }
    });
    });

  $('#affordpoint').on('change', function(event){

      var checkbox = $(event.target);
      var isChecked = $(checkbox).is(':checked');

      if(isChecked == true){
        var Apoint = $('#affordpoint').val();
        console.log(Apoint);
      $.ajax({
      url:"ajax-getAffordPoint.php",
      method:"POST",
      data:{Apoint:Apoint},
      //dataType:"json",
      success:function(data){
      $("#catdata").html(data);
      // console.log(data);
        //dataCategory = [data.gift, data.cash, data.voucher, data.item, data.other];
        //updateCat(dataCategory);
          }
        });
      }
      else{
        var varewardID = $('#affordpoint').data('id');
        console.log(varewardID);
      $.ajax({
      url:"ajax-vareward.php",
      method:"POST",
      data:{varewardID:varewardID},
      //dataType:"json",
      success:function(data){
      $("#catdata").html(data);
      console.log(data);
        //dataCategory = [data.gift, data.cash, data.voucher, data.item, data.other];
        //updateCat(dataCategory);
      }
    });
    }
  });

</script>
<!-- /#wrapper -->
<?php include 'include/form.php';?>