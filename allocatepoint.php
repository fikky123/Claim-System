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
     <h4 class="my-5"><i class='fa fa-map-pin'></i> Allocate Point</h4>


                      <div class="card mb-3 shadow-sm" >
                        <div class="card-body">
                          <div id="allocatepointview"></div>
                        </div>
                      </div>
      </div>
    </div>
</body>
          
 <script type='text/javascript'>
                $(document).ready(function(){
                  $(document).on('click', '#closepoint', function(){
                    $('#pform').modal('hide');
                    location.reload(); 
                  });
                });
  </script>
            <div class='modal fade' id='pointlogview' tabindex="-1">
              <div class='modal-dialog modal-lg modal-dialog-scrollable'>
                <div class='modal-content'>
                  <div class='modal-header bg-primary'>
                    <h6 class='modal-title text-white' id='pointlog'>History</h6>  
                    <button type='button' class='close text-white' id='closepoint' data-dismiss='modal'>&times;</button>
                  </div>
                  
                  <div class='modal-body'>
                    <form class='text-right'>
                        <select type='text' class='form-control-sm categorylog'>
                          <option type='text' value='allhistory'>All</option>
                          <option type='text' value='Claim Reward'>Claimed Reward</option>
                          <option type='text' value='Add point'>Added point</option>
                          <option type='text' value='Reduce Point'>Reduced Point</option>
                        </select>
                      </form>
                      <hr>
                    <input type='hidden' id='userid2' value=''>
                    <div id='pointlogviews'></div> 
                  </div>
                </div>
              </div>
            </div>

<script type="text/javascript">
$(document).ready(function(){

    function getAllocatepoints(){
      $.ajax({
        url:"ajax-getAllocatepoint.php",
        success:function(data){
          $("#allocatepointview").html(data);
        }
      });
    }

    getAllocatepoints();

  $("body").on("click", ".editpointall", function(e){

e.preventDefault();
pointID=$(this).attr('id');
$.ajax({
    url: "ajax-getpoint.php",
    type: "POST",
    data: {pointID:pointID},

    success:function(response){
    data = JSON.parse(response);
    
      
      // $("#pointlog").val(data.currentpoint);
      $("#pointID").val(data.pointID);
      $("#auserID").val(data.userID);
      $("#apcompanyID").val(data.companyID);
    }

  });

});


$("body").on("click", ".pointlogview", function(e){

e.preventDefault();
apuserID=$(this).attr('id');
// var apuserID = document.getElementById('apuserID').value;
  var alldata = 
      {
       apuserID:apuserID
      }
 console.log(alldata);
$.ajax({
    url: "ajax-getviewpointlog.php",
    method:'POST',
    data:alldata,
    dataType:'json',
    success:function(data){
    console.log(data);
    $("#userid2").val(data.apuserID);
    $('#pointlogviews').html(data.view);
    $('#pform').modal({show:true});
    }

  });

});

});

// $(document).on('click',function(){
// $('.collapse').collapse('hide');
// });
</script>

<?php include 'include/form.php';?>