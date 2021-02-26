<?php
if($resultresult->corporateID){
	$corporateobject = new Corporate();
	$corporateresult = $corporateobject->searchCorporate($resultresult->corporateID);
	if($corporateresult){
		if($corporateresult->package === "Trial"){
			$packageversion = "<span class='badge badge-pill badge-secondary mx-2'>Trial</span>";
			$navbarpackage = "Trial";
		}elseif($corporateresult->package === "Free"){
			$packageversion = "<span class='badge badge-pill badge-dark mx-2'>Free</span>";
        	$navbarpackage = "Free";
		}elseif($corporateresult->package === "Basic"){
			$packageversion = "<span class='badge badge-pill badge-info mx-2'>Basic</span>";
			$navbarpackage = "Basic";
		}elseif($corporateresult->package === "Pro"){
			$packageversion = "<span class='badge badge-pill badge-primary mx-2'>Pro</span>";
			$navbarpackage = "Pro";
		}elseif($corporateresult->package === "Business"){
			$packageversion = "<span class='badge badge-pill badge-danger mx-2''>Business</span>";
			$navbarpackage = "Business";
		}elseif($corporateresult->package === "Enterprise"){
			$packageversion = "<span class='badge badge-pill badge-dark mx-2' style='color:gold;'>Enterprise</span>";
			$navbarpackage = "Enterprise";
		}else{
			$packageversion = "";
		}
	}
}else{
	$companyobject = new Company();
	$companyresult = $companyobject->searchCompany($resultresult->companyID);
	if($companyresult){
		if($companyresult->package === "Trial"){
			$packageversion = "<span class='badge badge-pill badge-secondary mx-2'>Trial</span>";
			$navbarpackage = "Trial";
		}elseif($companyresult->package === "Free"){
			$packageversion = "<span class='badge badge-pill badge-dark mx-2'>Free</span>";
			$navbarpackage = "Free";
		}elseif($companyresult->package === "Basic"){
			$packageversion = "<span class='badge badge-pill badge-info mx-2'>Basic</span>";
			$navbarpackage = "Basic";
		}elseif($companyresult->package === "Pro"){
			$packageversion = "<span class='badge badge-pill badge-primary mx-2'>Pro</span>";
			$navbarpackage = "Pro";
		}elseif($companyresult->package === "Business"){
			$packageversion = "<span class='badge badge-pill badge-danger mx-2'>Business</span>";
			$navbarpackage = "Business";
		}elseif($companyresult->package === "Enterprise"){
			$packageversion = "<span class='badge badge-pill badge-dark mx-2' style='color:gold;'>Enterprise</span>";
			$navbarpackage = "Enterprise";
		}else{
			$packageversion = "";
		}
	}else{
		$packageversion = "";
	}
}

 if (empty($resultresult->corporateID) && empty($resultresult->companyID)) {
   $packageversion = "<span class='badge badge-pill badge-warning mx-2'>Coaching</span>";
			$navbarpackage = "Coaching";
  }

?>

<nav class="navbar navbar-expand-xl navbar-light bg-white sticky-top shadow-sm text-dark">
	<button class="btn" id="menu-toggle"><i class='fas fa-bars text-dark'></i></button>
	<a class="navbar-brand link font-poetsen-one mx-2" href="#" id="logo" style="font-size: 25px;"><span class="text-dark">Doer</span><span class="text-primary">HRM</span></a>
	<div class="dropdown mr-auto">
	  <button type="button" class="btn btn-lght dropdown-toggle" data-toggle="dropdown">
	    <i class='fas fa-globe'></i> 
	    <?php 

	    if(Input::get('lang')){
	    	$extlg = Input::get('lang');
	    	echo $extlg;
	    }else{
	    	$extlg = "en";
	    	echo $extlg;
	    }

	    if(Input::get('id')){
	    	$extid = "id=".Input::get('id')."&";
	    }else{
	    	$extid = "";
	    }
	    ?>
	  </button>
	  
	  <div class="dropdown-menu">
	    <a class="dropdown-item <?php if(Input::get('lang') === "en"){echo "active disabled";}?>" href="?<?php echo $extid;?>lang=en">en (English)</a>
	    <a class="dropdown-item <?php if(Input::get('lang') === "zh"){echo "active disabled";}?>" href="?<?php echo $extid;?>lang=zh">zh (简体中文)</a>
	    <a class="dropdown-item <?php if(Input::get('lang') === "bm"){echo "active disabled";}?>" href="?<?php echo $extid;?>lang=bm">bm (Bahasa Melayu)</a>
	  </div>
	</div> 
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
	   <span class="navbar-toggler-icon" style="color:black;"></span>
	</button>
	<div class="collapse navbar-collapse " id="collapsibleNavbar">
		<ul class="navbar-nav ml-auto ">	
		  <span class="navbar-text mt-1">
		    <?php echo $packageversion;?>
		  </span>
		  <!--<li class="nav-item">
		  	<a class="nav-link mt-2" href="#">
		  		<i class='fas fa-mail-bulk' style="font-size: 24px;"></i>
		  	</a>
		  </li>
		  <li class="nav-item">
		  	<a class="nav-link mt-2" href="#">
		  		<i class='far fa-question-circle' style="font-size: 24px;"></i>
		  	</a>
		  </li>-->
		  <li class="nav-item dropdown mr-4">
		    <a class="nav-link" href="#" id="navbardrop" data-toggle="dropdown">
		    	<?php
		    	if($resultresult->profilepic){
		    		?>
		    		<img src="data:image/jpeg;base64,<?php echo base64_encode($resultresult->profilepic);?>" class="rounded-circle" width="35" height="35" style="object-fit: cover;">
		    		<?php
		    	}else{
		    		?>
		    		<img src="img/userprofile.png" class="rounded-circle" width="35" height="35" style="object-fit: cover;">
		    		<?php
		    	}
		    	?>
				
			</a>
			<div class="dropdown-menu dropdown-menu-right rounded-lg shadow-lg">
				<a class='dropdown-item px-5 pt-3 text-center' href="personal.php?lang=<?php echo $extlg?>" id="personaltab">
					<?php
			    	if($resultresult->profilepic){
			    		$profilepic = "data:image/jpeg;base64,".base64_encode($resultresult->profilepic);
			    	}else{
			    		$profilepic = "img/userprofile.png";
			    	}
			    	?>
					<div class="media">
					  <img src="<?php echo $profilepic;?>" class="align-self-center mr-3" style="width:70px">
					  <div class="media-body">
					    <h5 class="font-weight-lighter"><?php echo $resultresult->firstname." ".$resultresult->lastname." <small class='badge badge-primary'>".$resultresult->role."</small> ";?></h5>
					    <p class="m-0"><?php echo $resultresult->email;?></p>
					  </div>
					</div>
				</a>

				<?php
				if($resultresult->role === "Client"){
					?><center><center>
					<a class='btn btn-outline-dark my-2' style="border-radius: 50px;" href='clientprofile.php?lang=<?php echo $extlg?>' id="clientdashboard">Company Profile</a>
				</center> <?php
				}
				if($resultresult->role == "Coach"){
				?>
				<center>
					<a class='btn btn-outline-dark my-2' style="border-radius: 50px;" href='coachprofile.php?lang=<?php echo $extlg?>' id="coachdashboardtab">Coach Profile</a>
				</center>
				
				<?php
				}?>

				<?php
				if($resultresult->admin == true){
					?>
					<center><div class="dropdown-header">Dashboard</div></center> 
					<center>
						<a class='btn btn-outline-dark my-2' style="border-radius: 50px;" href='dashboard-admin.php?lang=<?php echo $extlg?>' id="admindashboardtab"><?php echo $array['admindashboard']?></a>
					</center>
					<?php
						$userobject = new User();
						$userresult = $userobject->searchinviteduser($resultresult->userID);
						$onlyinvited = 0;
						if($userresult){
							$totalinvited = count($userresult);
							foreach ($userresult as $row) {
								if($row->status === "Done"){
									$onlyinvited++;
								}
							}
						}else{
							$totalinvited = 0;
						}
		
						if($onlyinvited >= 2 && $navbarpackage === "Trial"){
							?>
							<center>
								<button class='btn btn-lg btn-outline-warning my-2' type="button" onclick="upgradepackage(<?php echo $resultresult->companyID;?>)">Upgrade Now to Basic Package</button>
							</center>
							<?php
						}
		
						if($navbarpackage === "Trial" || $navbarpackage === "Free"){
							?>
							<center>
								<button class='btn btn-outline-success my-2' type="button" data-toggle="modal" data-target="#inviteusers">Successfully Invite 2 Users Now <br> for <br>Free Check In Customization</button>
							</center>
							<center><?php echo "<span id='totalinviteuser'>".$totalinvited."</span>";?> users invited | <?php echo "<span id='totalsuccess'>".$onlyinvited."</span>";?> users successfully invited</center>
							<?php
						}
					}
	
					?>
				<div class="dropdown-divider"></div>
				<center><a class="btn btn-outline-dark my-2" href="logout.php"><?php echo $array['logout']?></a></center>
				<div class="dropdown-divider"></div>
				<span class="dropdown-item-text"><center><small>DoerHRM</small></center></span>
			</div>
		  </li>
		</ul>
	</div>
</nav>
<style type="text/css">
	#myModal {
	    width:30%;
	    position:fixed;
	    bottom:60px;
	    right:5px;
	    margin:20px;
	    z-index: 2;
	}
	@media only screen and (max-width: 1200px) {
		#myModal {
		    width:50%;
		    position:fixed;
		    bottom:60px;
		    right:5px;
		    margin:20px;
		    z-index: 2;
		}
	}
	@media only screen and (max-width: 600px) {
		#myModal {
		    width:90%;
		    position:fixed;
		    bottom:60px;
		    right:5px;
		    margin:20px;
		    z-index: 2;
		}
	}
	#toggleguide {
	    position:fixed;
	    bottom:5px;
	    right:5px;
	    margin:20px;
	    z-index: 2;
	}
</style>
<div id="myModal" style="display: none">
	<div class='card shadow-lg rounded mb-2'>
		<div class="card-body bg-light">
		   <h6 class="mb-n1">Welcome to DoerHRM!</h6>
		</div>
	</div>

	<div class='card shadow-lg rounded'>
		<div class="card-body bg-light">
		  <div class="m-2">
		    We are platform that can help company to improve to another level. Are you lost? Let's see how can I help you?<br>
		    <?php
		    if($resultresult->admin == true){
		    	?>
		    	<a href="tutorial-admin.php" class="btn btn-outline-primary m-2" role="button" style="border-radius: 50px; border: 1px solid;"><b>Setup the Environment</b></a><br>
		    	<?php
		    }

		    if($resultresult->becomesupervisor == true){
		    	?>
		    	<a href="#" class="btn btn-outline-primary m-2" role="button" style="border-radius: 50px; border: 1px solid;">Supervisor & Trainee</a>
		    	<?php
		    }

		    if($navbarpackage === "Trial" || $navbarpackage === "Pro" || $navbarpackage === "Business" || $navbarpackage === "Enterprise"){
		    	?>
		    	<a href="tutorial-okr.php" class="btn btn-outline-primary m-2" role="button" style="border-radius: 50px; border: 1px solid;">How to use <b>OKR</b></a>
		    	<?php
		    }

		    if ($navbarpackage === "Business" || $navbarpackage === "Enterprise") {
		    	?>
		    	<a href="#" class="btn btn-outline-primary m-2" role="button" style="border-radius: 50px; border: 1px solid;">How to use <b>Coaching</b></a>
		    	<?php
		    }

		    if ($navbarpackage === "Enterprise"){
		    	?>
		    	<a href="#" class="btn btn-outline-primary m-2" role="button" style="border-radius: 50px; border: 1px solid;">How to use <b>KPI</b></a>
		    	<a href="#" class="btn btn-outline-primary m-2" role="button" style="border-radius: 50px; border: 1px solid;">How to use <b>360 Feedback</b></a>
		    	<?php
		    }
		    ?>
		  </div>
		</div>
	</div>
</div>

<button type="button" class="btn btn-primary btn-lg shadow-lg border border-white" style="border-radius: 100px; border: 1px solid;" id="toggleguide"><i class='fas fa-question'></i></button>

<script type="text/javascript">
	$(document).ready(function() {
	  if (window.localStorage.getItem("myModal") != null) {
	    var pb = window.localStorage.getItem("myModal");
	    if (pb == "true") {
	      $("#myModal").hide();
	    }else{
	      setTimeout($("#myModal").show('fade'), 1000);
	    }
	  }

	  $("#toggleguide").click(function() {
	    var v = $("#myModal").is(":visible")
	    $("#myModal").toggle('fade');
	    window.localStorage.setItem("myModal", v)
	  });
	});
</script>