  
<?php
require_once 'core/init.php'; 
if (Input::exists()) {
	// $currentuser= new User();
 //    $userid = $currentuser->data()->userID;
    $currentcompany = new User();
    $companyid = $currentcompany->data()->companyID;
    $currentcorporate= new User();
    $corporateid = $currentcorporate->data()->corporateID;

	$pointID = Input::get('pointID');
	$pointlogs = Input::get('pointlogs');
	$desclog = Input::get('desclog');
	$auserID = Input::get('auserID');

	$logrewarduser = new Preward();
    $key = $logrewarduser->searchPointReward4($pointID);

    $prevcurrentpoint =$key->currentpoint;
    $prevtotalpoint = $key->totalpoint;

	date_default_timezone_set('Asia/Kuala_Lumpur');
    $today = date('Y-m-d H:i:s');
	
	function checkValid($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}

	function checkPoint($data1, $newcurrentpoint){
		if(empty($data1)){
			return "Required";
		}
		else{
			if($newcurrentpoint <= 0){
				return "current point cannot be 0/-";
			}else{
				return "Valid";
			}
		}
	}

	$newcurrentpoint = ((int)$prevcurrentpoint+(int)$pointlogs);
	$newTotalPoint = ((int)$prevtotalpoint+(int)$pointlogs);


	function checkAllcondition($data1, $data2){
		if ($data1 === "Valid" && $data2 === "Valid") {
			return "Passed";
		}else{
			return "Failed";
		}
	}

	$pointlogerror = checkPoint($pointlogs, $newcurrentpoint);
	$desclogerror = checkValid($desclog);

	$allcondition = checkAllcondition($pointlogerror, $desclogerror);

	
	if ($allcondition === "Passed") {
		try{
			$prewardobject = new preward();
			$prewardobject->updatepoint(array(
				'currentpoint'=> $newcurrentpoint,
				'totalpoint' => $newTotalPoint,
            ),$pointID);

            // $id = $prewardobject->lastinsertid();
			if ($pointlogs > 0){
			$prewardobject->insertpointlog(array(
                'pointID' => $pointID,
				'previouspoint' => $prevcurrentpoint,
				'currentpoint' => $newcurrentpoint,
				'totalpoint' => $newTotalPoint,
				'description' => $desclog,
				'userID' => $auserID,
				'actionDate' => $today,
				'action_name'=>"Add Point",
            ));}

            else{
			$prewardobject->insertpointlog(array(
                'pointID' => $pointID,
				'previouspoint' => $prevcurrentpoint,
				'currentpoint' => $newcurrentpoint,
				'totalpoint' => $newTotalPoint,
				'description' => $desclog,
				'userID' => $auserID,
				'actionDate' => $today,
				'action_name'=>"Reduce Point",
            ));
            }
            			
			$array=[
				'pointlogs'=> $pointlogs,
				'currentpoint'=> $newcurrentpoint,
				'description' => $desclog,
				'condition'=> $allcondition
			];

		} catch (Exception $e){
			echo $e->getMessage();
		}
	}else{
		$array = [
				'currentpoint'=> $pointlogerror,
				'description' => $desclogerror,
				//'condition'=> $allcondition
				
		];
	}
	echo json_encode($array);
}
?>