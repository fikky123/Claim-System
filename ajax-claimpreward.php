
<?php
require_once 'core/init.php'; 
if (Input::exists()) {
	$currentuser= new User();
    $userid = $currentuser->data()->userID;
    $currentcompany = new User();
    $companyid = $currentcompany->data()->companyID;
    $currentcorporate= new User();
    $corporateid = $currentcorporate->data()->corporateID;

	$vrewardID = Input::get('vrewardID');
	$vpoints = Input::get('vpoints');
	$vquantity = Input::get('vquantity');

	$pr = new Preward();
	$currentpoint = $pr->searchPointReward2($userid);
	
	if(empty($currentpoint)){
	$tpoint = null;
	$pointID = null;
	$currentquantity = null;
	$rname = null;

	$totalcpoint = null;
	$totalquantity = null;
	}
	else{
	$tpoint = $pr->searchPointReward2($userid)->totalpoint;
	$pointID = $pr->searchPointReward2($userid)->pointID;
	$currentquantity = $pr->searchRewardID($vrewardID)->quantity;
	$currentpoint = $pr->searchPointReward2($userid)->currentpoint;
	$rname = $pr->searchRewardID($vrewardID)->reward;

	$totalcpoint = $currentpoint - $vpoints;
	$totalquantity = $currentquantity - 1;
	}

	function checkValid($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}

    function getCurrentTime(){

		date_default_timezone_set('Asia/Kuala_Lumpur');
		$date = date('Y-m-d H:i:s');

		return $date;
	}

	function checkCurrentPoint($data1, $currentpoint){
			if(empty($data1) || empty($currentpoint)){
				return "You don't have point";
			}
			elseif($currentpoint < $data1){
				return "Not enough point";
			}
			else{
				return "Valid";
			}
	}

	$date = getCurrentTime();

	function checkAllcondition($data1){
		if ($data1 === "Valid") {
			return "Passed";
		}else{
			return "Failed";
		}
	}

	$vpointserror = checkCurrentPoint($vpoints, $currentpoint);
	$allcondition = checkAllcondition($vpointserror);

	if ($allcondition === "Passed") {
		try{
			$prewardobject = new Preward();
			$prewardobject->insertclaimreward(array(
				'date' => $date,
				'rewardID' => $vrewardID,
				'userID' => $userid,
				'companyID' => $companyid,
				'corporateID' => $corporateid,
				'status' => 'Not Receive',
			));
			$prewardobject->updatepoint(array(
				'currentpoint'=> $totalcpoint,
				'userID' => $userid,
				'companyID' => $companyid,
				'corporateID' => $corporateid,
			),$pointID);
			$prewardobject->editpreward(array(
				'quantity'=> $totalquantity,
			),$vrewardID);
			$prewardobject->insertpointlog(array(
                'pointID' => $pointID,
				'previouspoint' => $currentpoint,
				'currentpoint' => $totalcpoint,
				'totalpoint' => $tpoint,
				'description' => "Claim ".$rname,
				'userID' => $userid,
				'actionDate' => $date,
				'action_name'=>"Claim Reward",
            ));
			
			$array=[
				'date' => $date,
				'rewardID' => $vrewardID,
				'currentpoint'=> $totalcpoint,
				'quantity' => $totalquantity,
				'condition'=> $allcondition
			];

		} catch (Exception $e){
			echo $e->getMessage();
		}
	}else{
		$array = [
				'date' => $date,
				'rewardID'=>$vrewardID,
				'currentpoint'=> $vpointserror,
				'quantity' => $totalquantity,
				"condition"=> $allcondition
				
		];
	}
	echo json_encode($array);
}
?>