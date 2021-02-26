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

?>
<body>
  <div class="d-flex" id="wrapper">
    <?php include 'include/navbar.php';?>
    <div class="container-fluid">
     <h4 class="my-5"><i class='fa fa-list-alt'></i>  Manage Reward</h4>

                          <div class="col text-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createpreward" data-backdrop="static"><i class='fas fa-plus'></i> Add Reward</button>
                          </div>
                     <div id="managerewardview"> </div>
    </div>
  </div>
</body>

    <!-- /#page-content-wrapper -->
<!--<script type="text/javascript">
  //$(document).ready(function(){
     //$("#sidebar-wrapper .active").removeClass("active");
    // $("#yourkpinavid").addClass("active");
 // });
</script> -->
<!-- /#wrapper -->
<script>

$(document).ready(function(){

    function getviewreward(){
      $.ajax({
        url:"ajax-getviewmanagereward.php",
        success:function(data){
          $("#managerewardview").html(data);
        }
      });
    }

    getviewreward();

  


  $("body").on("click", ".editbutton", function(e){

e.preventDefault();
rewardID=$(this).attr('id');
$.ajax({
    url: "ajax-getpointreward.php",
    type: "POST",
    data: {rewardID:rewardID},

    success:function(response){
    data = JSON.parse(response);
    
      
      $("#upreward").val(data.reward);
      $("#updesc").val(data.description);
      $("#upLimit").val(data.rewardLimit);
      $("#uppoints").val(data.points);
      $("#upcategory").val(data.category);
      $("#upexpdate").val(data.expiredate);
      $("#upentdate").val(data.entrydate);
      $("#upquantity").val(data.quantity);
      $("#rewardID").val(data.rewardID);
    }

  });

});

  $("body").on("click", ".deletebutton", function(e){

e.preventDefault();
rewardID=$(this).attr('id');
$.ajax({
    url: "ajax-getpointreward.php",
    type: "POST",
    data: {rewardID:rewardID},

    success:function(response){
    data = JSON.parse(response);
    
      
      $("#delpreward").val(data.reward);
      $("#delprewardID").val(data.rewardID);
      $("#delcompanyID").val(data.companyID);
    }

  });

});

  });
</script>
<?php include 'include/form.php';?>