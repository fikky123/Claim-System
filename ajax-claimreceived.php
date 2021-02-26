<?php
require_once 'core/init.php'; 
if (Input::exists()) {
	$currentuser= new User();
    $userid = $currentuser->data()->userID;
    $currentcompany = new User();
    $companyid = $currentcompany->data()->companyID;
    $currentcorporate= new User();
    $corporateid = $currentcorporate->data()->corporateID;

	$claimID = Input::get('claimID');
	$claimstatus = Input::get('claimstatus');
	
	function checkValid($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}


	function checkAllcondition($data1){
		if ($data1 === "Valid") {
			return "Passed";
		}else{
			return "Failed";
		}
	}

	// $claimstatuserror = checkValid($claimstatus);
	// $allcondition = checkAllcondition($claimstatuserror);

	// if ($allcondition === "Passed") {
	// 	try{
			$prewardobject = new Preward();
			$prewardobject->updateclaimed(array(
				'claim_rewardID'=> $claimID,
				'status'=> 'Received',
			),$claimID);
			
			$array=[
				'claim_rewardID'=> $claimID,
				'status' => 'Received',
				// 'condition'=> $allcondition
			];

	// 	} catch (Exception $e){
	// 		echo $e->getMessage();
	// 	}
	// }else{
	// 	$array = [
	// 			'status' => 'Received',
	// 			"condition"=> $allcondition
				
	// 	];
	// }
	echo json_encode($array);
}
?>