<!-- Claim Reward -->
<script type="text/javascript">
$(document).ready(function(){
	$('.afterviewreward').hide();
	var form = $('#viewrewardform');
	$("#vbutton").click(function(event){
		event.preventDefault();
		event.stopPropagation();
		const vquantity		= document.getElementById('vquantity').value;
		const vpoints 	= document.getElementById('vpoints').value;
		const vrewardID 	= document.getElementById('vrewardID').value;
  //     };
		// var alldata = form.serialize();
		const alldata = "&vrewardID="+vrewardID+"&vpoints="+vpoints;
		// console.log(alldata);
		console.log(alldata);
		$.ajax({
			url: "ajax-claimpreward.php",
			type: "POST",
			data: alldata,
			success:function(data){
				console.log(data);
				var obj = JSON.parse(data);
				console.log(obj);
				 if(obj.condition === "Passed"){
						$('.beforeviewreward').hide();
						$('.afterviewreward').show();
						loaddata();
						$(document).on('click', "#doneID5", function(){
			              $("#viewreward").modal("hide");
			              modalformrefresh();
			              loaddata();
			          });
			
				 
				}
				else{
					//checkvalidity("claim_rewardIDerror", "#claim_rewardIDerror", "claim_rewardID", obj.claim_rewardID);
					checkvalidity("vpointserror", "#vpointserror", "vpoints", obj.currentpoint);
					
					
					
				}
			}
		});
	});
	$(document).on('click', "#closeviewreward", function(){
		// location.reload();
		$("#viewreward").modal("hide");
		
	});
	function checkvalidity(data1, data2, data3, data4){
		document.getElementById(data1).innerHTML = data4;
		if (data4 === "Required") {
			$(data2).removeClass("text-success").addClass("text-danger");
			$(data3).removeClass("border-success").addClass("border-danger");
		}else if (data4 === "Valid") {
			$(data2).removeClass("text-danger").addClass("text-success");
			$(data3).removeClass("border-danger").addClass("border-success");
		}else{
			$(data2).removeClass("text-success").addClass("text-danger");
			$(data3).removeClass("border-success").addClass("border-danger");
		}
	}
	function clearform(data1, data2, data3){
		$(data1).removeClass("text-success").removeClass("text-danger");
		document.getElementById(data2).textContent=" ";
		$(data3).removeClass("border-success").removeClass("border-danger");
	}
	function modalformrefresh(){
		$('.beforeviewreward').show();
		$('.afterviewreward').hide();
		document.getElementById("viewrewardform").reset();
		 clearform("#vpointserror", "vpointserror", "#vpoints");
		 //clearform("#dateerror", "dateerror", "#date");
		 // location.reload();
		
	}
	function loaddata(){
      // var category = 'all';
      var category = $('#category').val();
      var afford = document.getElementById("affordpoint").checked;
      
      //var All = $('#category').val('All');
      //var chartType = $('#chartType').val();
      //var myChart = document.getElementById('myChart').getContext('2d');
      if(afford == true){
      	var Apoint = $('#affordpoint').val();
      	$.ajax({
      url:"ajax-getAffordPoint.php",
      method:"POST",
      data:{Apoint:Apoint},
      //dataType:"json",
      success:function(data){
      $("#catdata").html(data);
      console.log('afford');
        //dataCategory = [data.gift, data.cash, data.voucher, data.item, data.other];
        //updateCat(dataCategory);
          }
        });
      // console.log('afford');
      }
      else{
     
    $.ajax({
      url:"ajax-getcategory.php",
      method:"POST",
      data:{category:category},
      //dataType:"json",
      success:function(data){
        $("#catdata").html(data);
        console.log('all');
        //dataCategory = [data.gift, data.cash, data.voucher, data.item, data.other];
        //updateCat(dataCategory);
      }
    });
    // console.log('all');
    }
	}
});
//});
</script>

<div class="modal fade" id="viewreward" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary">
		 		<h5 class="modal-title" id="exampleModalLabel">Claim Reward</h5>
	  				<button type="button" class="close text-white" id="closeviewreward" data-dismiss="modal">&times;</button>
  			</div>
  		<div class="modal-body">
  			<div class="beforeviewreward">
  				<form id="viewrewardform">
					<input type="hidden" class="form-control type" name="vrewardID" id="vrewardID">
					
					<input type="hidden" class="form-control type" name="vquantity" id="vquantity">
						<div class="row">
							<p>Are you sure you want to claim this reward?	</p>
							<input type="hidden" class="form-control type" name="vpoints" id="vpoints">
							<small><span id="vpointserror"></span></small>
						</div>
						<br>
								
						<button name="submit" value="vbutton" type="submit" id="vbutton" class="btn btn-primary shadow-sm float-right">Claim</button>
				</form>
			</div>
				<div class="afterviewreward">
					<div class="p-5 text-center">
						<i class="fas fa-check-circle text-success my-3" style="font-size: 80px;"></i>
						<h4>You have successfully claim a Reward</h4>
						<button type="button" class="btn btn-outline-primary my-3" id="doneID5">Done</button>
					</div>
				</div>
			
		</div>
		
		</div>
	</div>
</div>
<!-- Claim Reward -->

<!-- Receive Reward -->
<script type="text/javascript">
$(document).ready(function(){
	$('.afterreceived').hide();
	var form = $('#receivedform');
	$("#rbutton").click(function(event){
		event.preventDefault();
		event.stopPropagation();
		const claimID		= document.getElementById('claimID').value;
		// const claimstatus 	= document.getElementById('claimstatus').value;
  //     };
		// var alldata = form.serialize();
		const alldata = "&claimID="+claimID;
		// console.log(alldata);
		console.log(alldata);
		$.ajax({
			url: "ajax-claimreceived.php",
			type: "POST",
			data: alldata,
			success:function(data){
				console.log(data);
				var obj = JSON.parse(data);
				console.log(obj);
				 // if(obj.condition === "Passed"){
						$('.beforereceived').hide();
						$('.afterreceived').show();
						loaddata3();
						$(document).on('click', "#doneID2", function(){
			              $("#receivereward").modal("hide");
			              modalformrefresh();
			              loaddata3();
			          });
			
				 
				// }
				// else{
					//checkvalidity("claim_rewardIDerror", "#claim_rewardIDerror", "claim_rewardID", obj.claim_rewardID);
					// checkvalidity("vpointserror", "#vpointserror", "vpoints", obj.currentpoint);
					
					
					
				// }
			}
		});
	});
	$(document).on('click', "#closereceived", function(){
		// location.reload();
		$("#receivereward").modal("hide");
		modalformrefresh();
		
	});
	function checkvalidity(data1, data2, data3, data4){
		document.getElementById(data1).innerHTML = data4;
		if (data4 === "Required") {
			$(data2).removeClass("text-success").addClass("text-danger");
			$(data3).removeClass("border-success").addClass("border-danger");
		}else if (data4 === "Valid") {
			$(data2).removeClass("text-danger").addClass("text-success");
			$(data3).removeClass("border-danger").addClass("border-success");
		}else{
			$(data2).removeClass("text-success").addClass("text-danger");
			$(data3).removeClass("border-success").addClass("border-danger");
		}
	}
	function clearform(data1, data2, data3){
		$(data1).removeClass("text-success").removeClass("text-danger");
		document.getElementById(data2).textContent=" ";
		$(data3).removeClass("border-success").removeClass("border-danger");
	}
	function modalformrefresh(){
		$('.beforereceived').show();
		document.getElementById("receivedform").reset();
		 // clearform("#vpointserror", "vpointserror", "#vpoints");
		 //clearform("#dateerror", "dateerror", "#date");
		 // location.reload();
		
	}

	function loaddata3(){
      var companyID = $('#companyID').val();
     
    $.ajax({
      url:"ajax-getclaimpointreward.php",
      method:"POST",
      data:{companyID:companyID},
      success:function(data){
        $("#claimpointrewardview").html(data);
        console.log('companyID');
      }
    });

	}
});

</script>
<div class="modal fade" id="receivereward" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary">
		 		<h5 class="modal-title" id="exampleModalLabel">Claim Reward</h5>
	  				<button type="button" class="close text-white" id="closereceived" data-dismiss="modal">&times;</button>
  			</div>
  		<div class="modal-body">
  			<div class="beforereceived">
  				<form id="receivedform">
					<input type="hidden" class="form-control type" name="claimID" id="claimID">
					
					<!-- <input type="hidden" class="form-control type" name="claimstatus" id="claimstatus"> -->
						<div class="row">
							<p>Are you sure the user has received the claimed reward?</p>
						</div>
						<br>
								
						<button name="submit" value="rbutton" type="submit" id="rbutton" class="btn btn-primary shadow-sm float-right">Yes</button>
				</form>
			</div>
				<div class="afterreceived">
					<div class="p-5 text-center">
						<i class="fas fa-check-circle text-success my-3" style="font-size: 80px;"></i>
						<h4>You have successfully confirmed the claimed reward</h4>
						<button type="button" class="btn btn-outline-primary my-3" id="doneID2">Done</button>
					</div>
				</div>
			
		</div>
		
		</div>
	</div>
</div>
<!-- Receive Reward -->