<!--Allocate point Reward -->
<script type="text/javascript">
	$(document).ready(function(){
		$('.aftercreateapoint').hide();
		var form = $('#createapointform');
		form.on('submit', function(e){
			e.preventDefault();
			e.stopPropagation();

			//const rewardID = document.getElementById('rewardID').value;
			const pointID = document.getElementById('pointID').value;
			const auserID = document.getElementById('auserID').value;
			const pointlogs = document.getElementById('pointlogs').value;
			const desclog = document.getElementById('desclog').value;
			// var alldata = form.serialize();
			const alldata = "&pointID="+pointID+"&auserID="+auserID+"&pointlogs="+pointlogs+"&desclog="+desclog;
			console.log(alldata);

			 // console.log(reward_img);
			$.ajax({
				url: "ajax-allocatepoint.php",
				type: "POST",
				data: alldata,
				success:function(data){
					var obj = JSON.parse(data);
					console.log(obj);
					if(obj.condition === "Passed"){
						$('.beforecreateapoint').hide();
						$('.aftercreateapoint').show();
						loaddata4();

						$(document).on('click', "#doneID6", function(){
			              $("#editpoint").modal("hide");
			              modalformrefresh();
			              loaddata4();
			          });

					}else{
						checkvalidity("pointlogerror", "#pointlogerror", "#pointlogs", obj.currentpoint);
						checkvalidity("desclogerror", "#desclogerror", "#desclog", obj.description);
					}
				}
			});
		});

		$(document).on('click', "#closeallocatepoint", function(){
			$("#editpoint").modal("hide");
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
			$('.beforecreateapoint').show();
			$('.aftercreateapoint').hide();
			document.getElementById("createapointform").reset();
			 clearform("#pointlogerror", "pointlogerror", "#pointlog");
			 clearform("#desclogerror", "desclogerror", "#desclog");
			// location.reload();
		}

	function loaddata4(){
      var companyID = $('#companyID').val();
     
    $.ajax({
      url:"ajax-getAllocatepoint.php",
      method:"POST",
      data:{companyID:companyID},
      success:function(data){
        $("#allocatepointview").html(data);
        console.log('companyID');
      }
    });

	}

});
</script>



<div class="modal fade" id="editpoint" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h6 class="modal-title text-white">Allocate Point</h6>
				<button type="button" class="close text-white" id="closeallocatepoint" data-dismiss="modal">&times;</button>
			</div><!-- class="modal-header bg-primary" -->
			<div class="modal-body">
				<div class="beforecreateapoint">
					<form id="createapointform">
					
					<input type="hidden" class="form-control type" name="pointID" id="pointID" value="">
					<input type="hidden" class="form-control type" name="auserID" id="auserID" value="">
			
						<div class="form">
							<div class="row">
								<div class="col">
									<label>Add/Reduce Point</label>
								</div>
								<div class="col">
									<input type="number" class="form-control shadow-sm" id="pointlogs" name="pointlogs" autocomplete="off">
									<small><span id="pointlogerror"></span></small>
								</div>
							</div><br>
							<div class="row">
								<div class="col">
									<label>Description</label>
								</div>
								<div class="col">
									<input type="text" class="form-control shadow-sm" id="desclog" name="desclog" value="" autocomplete="off">
									<small><span id="desclogerror"></span></small>
								</div>
							</div><br>
							
                  
						</div>			
						<br>								
						<button name="submit" value="submitapoint" type="submit" id="submitapoint" class="btn btn-info shadow-sm float-right">Edit</button>
					</form>
					
				</div><!-- class="beforecreatepreward" -->
				<div class="aftercreateapoint">
					<div class="p-5 text-center">
						<i class="fas fa-check-circle text-success my-3" style="font-size: 80px;"></i>
						<h4>You have successfully allocate the point</h4>
						<button type="button" class="btn btn-outline-primary my-3" id="doneID6">Done</button>
					</div>
				</div>
			</div><!-- modal-body -->
			
		</div><!-- class="modal-content" -->
	 </div><!--class="modal-dialog modal-lg" -->
</div><!--  class="modal fade" id="addkpi" -->
<!-- Allocate point Reward -->