<!-- Create Reward -->
<script type="text/javascript">
	$(document).ready(function(){
		$('.aftercreatepreward').hide();
		var form = $('#createprewardform');
		form.on('submit', function(e){
			e.preventDefault();
			e.stopPropagation();
			//const rewardID = document.getElementById('rewardID').value;
			const reward = document.getElementById('reward').value;
			const description = document.getElementById('description').value;
			const rewardLimit = document.getElementById('rewardLimit').value;
			const points = document.getElementById('points').value;
			const category = document.getElementById('category').value;
			const expiredate = document.getElementById('expiredate').value;
			const entrydate = document.getElementById('entrydate').value;
			const quantity = document.getElementById('quantity').value;
			const reward_img = document.getElementById('reward_img').files;
			// var alldata = form.serialize();
			const alldata = "&reward="+reward+"&description="+description+"&rewardLimit="+rewardLimit+"&points="+points+"&category="+category+"&expiredate="+expiredate+"&entrydate="+entrydate+"&quantity="+quantity+"&reward_img="+reward_img;
			// console.log(alldata);
			 console.log(reward_img);
			$.ajax({
				url: "ajax-createpointreward.php",
				type: "POST",
				data: new FormData(this),
				// dataType:"json",
				contentType: false,
		        cache: false,
		   		processData: false,
				success:function(data){
					var obj = JSON.parse(data);
					console.log(obj);
					if(obj.condition === "Passed"){
						$('.beforecreatepreward').hide();
						$('.aftercreatepreward').show();
						loaddata();
						$(document).on('click', "#doneAddPID", function(){
			              $("#createpreward").modal("hide");
			              modalformrefresh();
			              loaddata();
			          });
					}else{
						checkvalidity("prewardnameerror", "#prewardnameerror", "#reward", obj.reward);
						checkvalidity("descriptionerror", "#descriptionerror", "#description", obj.description);
						checkvalidity("rewardLimiterror", "#rewardLimiterror", "#rewardLimit", obj.rewardLimit);
						checkvalidity("pointserror", "#pointserror", "#points", obj.points);
						checkvalidity("categoryerror", "#categoryerror", "#category", obj.category);
						checkvalidity("expiredateerror", "#expiredateerror", "#expiredate", obj.expiredate);
						checkvalidity("entrydateerror", "#entrydateerror", "#entrydate", obj.entrydate);
						checkvalidity("quantityerror", "#quantityerror", "#quantity", obj.quantity);
					}
				}
			});
		});
		$(document).on('click', "#closecreatepreward", function(){
			$("#createpreward").modal("hide");
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
			$('.beforecreatepreward').show();
			$('.aftercreatepreward').hide();
			document.getElementById("createprewardform").reset();
			 clearform("#prewardnameerror", "prewardnameerror", "#reward");
			 clearform("#descriptionerror", "descriptionerror", "#description");
			 clearform("#rewardLimiterror", "rewardLimiterror", "#rewardLimit");
			 clearform("#pointserror", "pointserror", "#points");
			 clearform("#categoryerror", "categoryerror", "#category");
			 clearform("#expiredateerror", "expiredateerror", "#expiredate");
			 clearform("#entrydateerror", "entrydateerror", "#entrydate");
			 clearform("#quantityerror", "quantityerror", "#quantity");
			// location.reload();
		}

		function loaddata(){
      var companyID = $('#companyID').val();
     
    $.ajax({
      url:"ajax-getviewmanagereward.php",
      method:"POST",
      data:{companyID:companyID},
      success:function(data){
        $("#managerewardview").html(data);
        console.log('companyID');
      }
    });

	}
	
});
</script>



<div class="modal fade" id="createpreward">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h6 class="modal-title text-white">Create Rewards</h6>
				<button type="button" class="close text-white" id="closecreatepreward">&times;</button>
			</div><!-- class="modal-header bg-primary" -->
			<div class="modal-body">
				<div class="beforecreatepreward">
					<form id="createprewardform">
					
					<!--<input type="hidden" class="form-control type" name="rewardID" id="rewardID" value="">-->
			
						<div class="form">
							<div class="row">
								<div class="col">
									<label>Name</label>
								</div>
								<div class="col">
									<input type="text" class="form-control shadow-sm" id="reward" name="reward" value="" autocomplete="off">
									<small><span id="prewardnameerror"></span></small>
								</div>
							</div><br>
							<div class="row">
								<div class="col">
									<label>Description</label>
								</div>
								<div class="col">
									<input type="text" class="form-control shadow-sm" id="description" name="description" value="" autocomplete="off">
									<small><span id="descriptionerror"></span></small>
								</div>
							</div><br>
							<div class="row">
								<div class="col">
									<label>Limit (Per Person)</label>
								</div>
								<div class="col">
									<input type="number" class="form-control shadow-sm" id="rewardLimit" name="rewardLimit" value="" autocomplete="off">
									<small><span id="rewardLimiterror"></span></small>
								</div>
							</div><br>
							<div class="row">
								<div class="col">
									<label>Point</label>
								</div>
								<div class="col">
									<input type="number" class="form-control shadow-sm" id="points" name="points" value="" autocomplete="off">
									<small><span id="pointserror"></span></small>
								</div>
							</div><br>
							<div class="row">
								<div class="col">
									<label>Category</label>
								</div>
								<div class="col">
									<select class="form-control" id="category" name="category">
										<option value="Gift">Gift</option>
										<option value="Cash">Cash</option>
										<option value="Voucher">Voucher</option>
										<option value="Item">Item</option>
										<option value="Other">Other</option>
     								</select>
									<small><span id="categoryerror"></span></small>
								</div>
							</div><br>
							<div class="row">
								<div class="col">
									<label>Deadline</label>
								</div>
								<div class="col">
									<input type="date" class="form-control shadow-sm" id="expiredate" name="expiredate" value="" autocomplete="off">
									<small><span id="expiredateerror"></span></small>
								</div>
							</div><br>
							<div class="row">
								<div class="col">
									<label>Entry Date</label>
								</div>
								<div class="col">
									<input type="date" class="form-control shadow-sm" id="entrydate" name="entrydate" value="" autocomplete="off">
									<small><span id="entrydateerror"></span></small>
								</div>
							</div><br>
							<div class="row">
								<div class="col">
									<label>Quantity</label>
								</div>
								<div class="col">
									<input type="number" class="form-control shadow-sm" id="quantity" name="quantity" value="" autocomplete="off">
									<small><span id="quantityerror"></span></small>
								</div>
							</div><br>
							<div class="row">
								<div class="col">
									<label>Upload picture</label>
								</div>
								<div class="col">
									<div class="custom-file">
                  						<input type="file" class="custom-file-lable" name="reward_img" id="reward_img" accept="image/*" for="upload_image"/>
                  					</div>
                  				</div>
							</div><br>
                  
						</div>			
						<br>								
						<button name="submit" value="submitpreward" type="submit" id="submitpreward" class="btn btn-info shadow-sm float-right">Create</button>
					</form>
					
				</div><!-- class="beforecreatepreward" -->
				<div class="aftercreatepreward">
					<div class="p-5 text-center">
						<i class="fas fa-check-circle text-success my-3" style="font-size: 80px;"></i>
						<h4>You have successfully add a Point Reward</h4>
						<button type="button" class="btn btn-outline-primary my-3" id="doneAddPID">Done</button>
					</div>
				</div>
			</div><!-- modal-body -->
			
		</div><!-- class="modal-content" -->
	 </div><!--class="modal-dialog modal-lg" -->
</div><!--  class="modal fade" id="addkpi" -->
<!-- End Create Reward -->

<!-- Edit Reward -->
<script type="text/javascript">
$(document).ready(function(){
	$('.aftereditpreward').hide();
	var form = $('#editprewardform');
	form.on('submit', function(event){
		event.preventDefault();
		event.stopPropagation();
		const upreward = document.getElementById('upreward').value;
		const updesc = document.getElementById('updesc').value;
		const upLimit = document.getElementById('upLimit').value;
		const uppoints = document.getElementById('uppoints').value;
		const upcategory = document.getElementById('upcategory').value;
		const upexpdate = document.getElementById('upexpdate').value;
		const upentdate = document.getElementById('upentdate').value;
		const rewardID 	= document.getElementById('rewardID').value;
		const upquantity = document.getElementById('upquantity').value;
		const upreward_img = document.getElementById('upreward_img').files;
		
		// var alldata = {
  //       upreward:upreward, 
  //       updesc:updesc, 
  //       upLimit:upLimit, 
  //       uppoints:uppoints, 
  //       upcategory:upcategory, 
  //       upexpdate:upexpdate, 
  //       upentdate:upentdate,
  //       rewardID:rewardID
  //     };
		// var alldata = form.serialize();
		const alldata = "&upreward="+upreward+"&updesc="+updesc+"&upLimit="+upLimit+"&uppoints="+uppoints+"&upcategory="+upcategory+"&upexpdate="+upexpdate+"&upentdate="+upentdate+"&rewardID="+rewardID+"&upquantity="+upquantity+"&upreward_img="+upreward_img;
		// console.log(alldata);
		console.log(alldata);
		$.ajax({
			url: "ajax-editpreward.php",
			type: "POST",
			data: new FormData(this),
			//alldata,
			//new FormData(this),
				// dataType:"json",
				contentType: false,
		        cache: false,
		    	processData: false,
			success:function(data){
				console.log(data);
				var obj = JSON.parse(data);
				console.log(obj);
				if(obj.condition === "Passed"){
					// location.reload();
					$('.beforeeditpreward').hide();
					$('.aftereditpreward').show();
					loaddata1();
					// modalformrefresh();
					
					$(document).on('click',"#doneEditPID", function(){
						$('#editpreward').modal("hide");
						modalformrefresh();
						loaddata1();
					})
			
				 
				}else{
					checkvalidity("uprewarderror", "#uprewarderror", "upreward", obj.reward);
					checkvalidity("updescerror", "#updescerror", "updesc", obj.description);
					checkvalidity("upLimiterror", "#upLimiterror", "upLimit", obj.rewardLimit);
					checkvalidity("uppointerror", "#uppointerror", "uppoints", obj.points);
					checkvalidity("upcaterror", "#upcaterror", "upcategory", obj.category);
					checkvalidity("upexpdateerror", "#upexpdateerror", "upexpdate", obj.expiredate);
					checkvalidity("upentdateerror", "#upentdateerror", "upentdate", obj.entrydate);
					checkvalidity("upquantityerror", "#upquantityerror", "upquantity", obj.quantity);
					
					
				}
			}
		});
	});
	$(document).on('click', "#closeeditprewardmodal", function(){
	$("#editpreward").modal("hide");
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
		$('.beforeeditpreward').show();
		$('.aftereditpreward').hide();
		document.getElementById("editprewardform").reset();
		clearform("#uprewarderror", "uprewarderror", "#upreward");
		clearform("#updescerror", "updescerror", "#updesc");
		clearform("#upLimiterror", "upLimiterror", "#upLimit");
		clearform("#uppointerror", "uppointerror", "#uppoints");
		clearform("#upcaterror", "upcaterror", "#upcategory");
		clearform("#upexpdateerror", "upexpdateerror", "#upexpdate");
		clearform("#upentdateerror", "upentdateerror", "#upentdate");
		clearform("#upquantityerror", "upquantityerror", "#upquantity");
		// location.reload();
	}

	function loaddata1(){
      var companyID = $('#companyID').val();
     
    $.ajax({
      url:"ajax-getviewmanagereward.php",
      method:"POST",
      data:{companyID:companyID},
      success:function(data){
        $("#managerewardview").html(data);
        console.log('companyID');
      }
    });

	}
});
</script>
<div class="modal fade" id="editpreward">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h6 class="modal-title text-white">Edit Point Reward</h6>
				<button type="button" class="close text-white" id="closeeditprewardmodal">&times;</button>
			</div><!-- class="modal-header bg-primary" -->
			<div class="modal-body">
				<div class="beforeeditpreward">
					<form id="editprewardform">
					
					  <input type="hidden" class="form-control type" name="rewardID" id="rewardID" value="">
					  
						<div class="form">
							<div class="row">
								<div class="col">
									<label>Name</label>
								</div>
								<div class="col">
									<input type="text" class="form-control shadow-sm" id="upreward" name="upreward" value="" autocomplete="off">
									<small><span id="uprewarderror"></span></small>
								</div>
							</div><br>
							<div class="row">
								<div class="col">
									<label>Description</label>
								</div>
								<div class="col">
									<input type="text" class="form-control shadow-sm" id="updesc" name="updesc" value="" autocomplete="off">
									<small><span id="updescerror"></span></small>
								</div>
								</div><br>
							<div class="row">
								<div class="col">
									<label>Limit (Per Person)</label>
								</div>
								<div class="col">
									<input type="number" class="form-control shadow-sm" id="upLimit" name="upLimit" value="" autocomplete="off">
									<small><span id="upLimiterror"></span></small>
								</div>
							</div><br>
							<div class="row">
								<div class="col">
									<label>Point</label>
								</div>
								<div class="col">
									<input type="number" class="form-control shadow-sm" id="uppoints" name="uppoints" value="" autocomplete="off">
									<small><span id="uppointerror"></span></small>
								</div>
						</div><br>
						<div class="row">
							<div class="col">
								<label>Category</label>
							</div>
							<div class="col">
								<select class="form-control" id="upcategory" name="upcategory">
									<option value="Gift">Gift</option>
									<option value="Cash">Cash</option>
									<option value="Voucher">Voucher</option>
									<option value="Item">Item</option>
									<option value="Other">Other</option>
     							</select>
								<small><span id="upcaterror"></span></small>
							</div>
						</div><br>
						<div class="row">
							<div class="col">
								<label>Deadline</label>
							</div>
							<div class="col">
								<input type="date" class="form-control shadow-sm" id="upexpdate" name="upexpdate" value="" autocomplete="off">
								<small><span id="upexpdateerror"></span></small>
							</div>
						</div><br>
						<div class="row">
							<div class="col">
								<label>Entry Date</label>
							</div>
							<div class="col">
								<input type="date" class="form-control shadow-sm" id="upentdate" name="upentdate" value="" autocomplete="off">
								<small><span id="upentdateerror"></span></small>
							</div>
						</div><br>
						<div class="row">
							<div class="col">
								<label>Quantity</label>
							</div>
							<div class="col">
								<input type="number" class="form-control shadow-sm" id="upquantity" name="upquantity" value="" autocomplete="off">
								<small><span id="upquantityerror"></span></small>
							</div>
						</div><br>
						<div class="row">
							<div class="col">
								<label>Upload picture</label>
							</div>
							<div class="col">
								<div class="custom-file">
                  					<input type="file" class="custom-file-lable" name="upreward_img" id="upreward_img" accept="image/*" for="upload_image"/>
                  				</div>
                  			</div>
						</div><br>
					</div>				
					<br>								
						<button name="submit" value="Editr" type="submit" id="Editr" class="btn btn-info shadow-sm float-right">Edit</button>
					</form>					
				</div><!-- class="beforeaddkpi" -->
				<div class="aftereditpreward">
					<div class="p-5 text-center">
						<i class="fas fa-check-circle text-success my-3" style="font-size: 80px;"></i>
						<h4>You have successfully Edit a Point Reward</h4>
						<button type="button" class="btn btn-outline-primary my-3" id="doneEditPID">Done</button>
					</div>
				</div>
			</div><!-- modal-body -->
			
		</div><!-- class="modal-content" -->
	 </div><!--class="modal-dialog modal-lg" -->
</div><!--  class="modal fade" id="addkpi" -->
<!-- End Edit Reward -->

<!-- Remove Reward -->
<script type="text/javascript">
$(document).ready(function(){
	$('.afterremovepreward').hide();
	var form = $('#removeprewardform');
	$("#sdelpreward").click(function(event){
		event.preventDefault();
		event.stopPropagation();

		const delprewardID 		= document.getElementById('delprewardID').value;
		const delpreward		= document.getElementById('delpreward').value;
		
		const alldata = "&delprewardID="+delprewardID+"&delpreward="+delpreward;

		
		// console.log(alldata);

		console.log(alldata);
		$.ajax({
			url: "ajax-deletepreward.php",
			type: "POST",
			data: alldata,
			success:function(data){

				console.log(data);
				var obj = JSON.parse(data);
				console.log(obj);
				//if(obj.condition === "Passed"){
					$('.beforeremovepreward').hide();
					$('.afterremovepreward').show();
					loaddata2();

			$(document).on('click', "#doneDelPID", function(){
			              $("#removepreward").modal("hide");
			              modalformrefresh();
			              loaddata2();
			          });
				 //
				//}
				//else{
					// checkvalidity("delprIDerror", "#delprIDerror", "delprewardID", obj.rewardID);
					// checkvalidity("delprerror", "#delprerror", "delpreward", obj.reward);
					// checkvalidity("upkpiclasserror", "#kuppiclasserror", "uprewardclass", obj.class);
					// checkvalidity("upkpicaterror", "#upkpicaterror", "uprewardcategory", obj.category );
					// checkvalidity("upkpidateerror", "#upkpidateerror", "upmyDate", obj.entrydate );
					
					
					
				//}
			}
		});
	});

	$(document).on('click', "#closeremovepreward", function(){
		// location.reload();
		$("#removepreward").modal("hide");
		
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
		$('.beforeremovepreward').show();
		document.getElementById("removeprewardform").reset();

	}

	function loaddata2(){
      var companyID = $('#companyID').val();
     
    $.ajax({
      url:"ajax-getviewmanagereward.php",
      method:"POST",
      data:{companyID:companyID},
      success:function(data){
        $("#managerewardview").html(data);
        console.log('companyID');
      }
    });

	}
});
</script>

<div class="modal fade" id="removepreward" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary">
		 		<h5 class="modal-title" id="exampleModalLabel">Delete Point Reward</h5>
	  				<button type="button" class="close text-white" id="closeremovepreward" data-dismiss="modal">&times;</button>
  			</div>
  		<div class="modal-body">
  			<div class="beforeremovepreward">
  				<form id="removeprewardform'">

					<input type="hidden" class="form-control type" name="delprewardID" id="delprewardID" value="">
					<input type="hidden" class="form-control type" name="delpreward" id="delpreward" value="">

						<div class="row">
							<p>Are you sure you want to delete?</p>
						</div>
						<br>
								
						<button name="submit" value="sdelpreward" type="submit" id="sdelpreward" class="btn btn-danger shadow-sm float-right">Delete</button>

				
				</form><!--removeprewardform-->
			</div><!--beforeremovepreward-->

				<div class="afterremovepreward">
					<div class="p-5 text-center">
						<i class="fas fa-check-circle text-success my-3" style="font-size: 80px;"></i>
						<h4>You have successfully delete a Point Reward</h4>
						<button type="button" class="btn btn-outline-primary my-3" id="doneDelPID">Done</button>
					</div>
				</div>
		</div><!--Modal body -->
		
		</div><!--modal content-->
	</div><!--modal dialog-->
</div><!--modal fade-->
<!-- End remove Reward -->		
