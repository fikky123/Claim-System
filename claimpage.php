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
    <div class="container-fluid" >
     <h4 class="my-5"><i class='fa fa-list-alt'></i> Claim Page</h4>

                  
                      <div class="row">
                       <div class="col">
                      <div id="claimpointrewardview"></div>
                        </div>
                      </div>
   
              </div>
            </div>
            </body> 
          


<script type="text/javascript">


$(document).ready(function(){

    function getclaimpointrewards(){
      $.ajax({
        url:"ajax-getclaimpointreward.php",
        success:function(data){
          $("#claimpointrewardview").html(data);
        }
      });
    }

    getclaimpointrewards();

 $("body").on("click", ".receivereward", function(e){

e.preventDefault();
claimID=$(this).attr('id');
$.ajax({
    url: "ajax-getclaimedreward.php",
    type: "POST",
    data: {claimID:claimID},

    success:function(response){
    data = JSON.parse(response);
    
      $("#claimID").val(data.claim_rewardID);
      $("#claimcompID").val(data.companyID);
    }

  });

});

});
</script>
<?php include 'include/form.php';?>