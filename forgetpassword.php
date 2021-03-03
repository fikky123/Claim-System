<?php
require_once 'core/init.php';
include 'include/header.php';
?>
<script type="text/javascript">
  $(document).ready(function(){
    $('.after').hide();
    $('#forgetemailnotfound').hide();
    var form = $('#forgetpasswordform');
    form.on('submit', function(e){
      e.preventDefault();
      e.stopPropagation();
      var email = document.getElementById("email").value;
      var alldata = "email="+email;
      console.log(alldata);
      $.ajax({
        url: "ajax-forgetpassword.php",
        type: "POST",
        data: alldata,
        success:function(data){
          var obj = JSON.parse(data);
          console.log(obj);
          if(obj.condition === "Passed"){
            if(obj.emailerror){
              $('#forgetemailnotfound').show();
            }else{
              $('.before').hide();
              $('.after').show();
              document.getElementById("recoveryemail").innerHTML = obj.email;
            }

          }else{
            checkvalidity("emailerror","#emailerror", "#email", obj.email);
          }
        }
      });
    });

    function checkvalidity(data1, data2, data3, data4){
      document.getElementById(data1).innerHTML = data4;
      if(data4 === "Required"){
        $(data2).removeClass("text-success").addClass("text-danger");
        $(data3).removeClass("border-success").addClass("border-danger");
      }else if(data4 === "Valid"){
        $(data2).removeClass("text-danger").addClass("text-success");
        $(data3).removeClass("border-danger").addClass("border-success");
      }else{
        $(data2).removeClass("text-success").addClass("text-danger");
        $(data3).removeClass("border-success").addClass("border-danger");
      }
    }

    function clearform(data1, data2, data3){
      $(data1).removeClass("text-success").removeClass("text-danger");
      document.getElementById(data2).innerHTML="";
      $(data3).removeClass("border-success").removeClass("border-danger");
    }

  });
</script>
<body class="bg-light">
  <div class="row">
    <div class="col"></div>

    <div class="col my-5 py-5">
      <div class="before">
            <div class="text-center mb-5 mt-3">
              <h4>Welcome to <a class="navbar-brand link font-poetsen-one" href="/index.php" id="logo" style="font-size: 25px;"><span class="text-dark">Claim System</span></a></h4>
              <h5>Forget Password </h5>
              <small>Back to <a href="login.php">Login</a></small>
            </div>
            <div class='alert alert-danger alert-dismissible' id="forgetemailnotfound">
              <button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Email not found</strong>
            </div>
            <form id="forgetpasswordform">
              <div class="form-group">
                <div class="row">
                  <div class="col-3"><label>Email :</label></div>
                  <div class="col">
                    <input type="text" class="form-control form-control-sm shadow-sm" id="email" name="email" autocomplete="off">
                    <small><span id="emailerror"></span></small>
                  </div>
                </div>
              </div>
              
              <div class="text-center">
                <button name="submit" value="login" type="submit" class="btn btn-primary shadow-sm">Submit</button>
              </div>

            </form>
          </div>
          <div class="after">
            <div class="p-5 text-center">
              <i class='far fa-check-circle text-success my-3' style='font-size:80px;'></i>
              <h4>Yey get new password <span id="recoveryemail"></span></h4>
              <a href="login.php" class="btn btn-outline-primary my-3" role="button">Login Now !</a>
            </div>
          </div>
    </div>
    <div class="col"></div>
  </div>

  </div>
    <!-- /#page-content-wrapper -->
</div>
<!-- /#wrapper -->

