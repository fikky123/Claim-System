
<?php
require_once 'core/init.php'; 
if (Input::exists()) {
	$currentuser= new User();
    $userid = $currentuser->data()->userID;
    $currentcompany = new User();
    $companyid = $currentcompany->data()->companyID;
    $currentcorporate= new User();
    $corporateid = $currentcorporate->data()->corporateID;

	$reward = Input::get('reward');
	$description = Input::get('description');
	$rewardLimit = Input::get('rewardLimit');
	$points = Input::get('points');
	$category = Input::get('category');
	$expiredate = Input::get('expiredate');	
	$entrydate = Input::get('entrydate');
	$quantity = Input::get('quantity');
	$reward_img = Input::get('reward_img');

	if(!empty($_FILES['reward_img']['name'])){
		$files = file_get_contents($_FILES['reward_img']['tmp_name']);
		// print_r($files);
	}
	else{
		$files = null;
	}

	
	function checkValid($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}

    function checkInt($value){
		if(empty($value)){
			return "Required";
		}else{
			if(is_numeric($value)){
				return "Valid";
			}else{
				return "Required";
			}
		}

	}



	function checkAllcondition($data1, $data2, $data3, $data4, $data5, $data6, $data7, $data8){
		if ($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 ==="Valid" && $data5 ==="Valid" && $data6 ==="Valid" && $data7 === "Valid" && $data8 === "Valid") {
			return "Passed";
		}else{
			return "Failed";
		}
	}

	$prewardnameerror = checkValid($reward);
	$descriptionerror = checkValid($description);
	$rewardLimiterror = checkInt($rewardLimit);
	$pointserror = checkInt($points);
	$categoryerror = checkValid($category);
	$expiredateerror = checkValid($expiredate);
	$entrydateerror = checkValid($entrydate);
	$quantityerror = checkInt($quantity);

	$allcondition = checkAllcondition($prewardnameerror, $descriptionerror,$rewardLimiterror,$pointserror, $categoryerror,$expiredateerror, $entrydateerror, $quantityerror);

	if ($allcondition === "Passed") {
		try{
			$prewardobject = new preward();
			$prewardobject->createpreward(array(
				'reward'=> $reward,
				'description' => $description,
				'rewardLimit' => $rewardLimit,
				'points' => $points,
				'category' => $category,
				'expiredate' => $expiredate,
				'entrydate' => $entrydate,
				'userID' => $userid,
				'companyID' => $companyid,
				'corporateID' => $corporateid,
				'quantity' => $quantity,
				'reward_img' => $files
				//"lastinsertid"=>$id
	
            ));

            $id = $prewardobject->lastinsertid();

            $prewardobject = new preward();
			$prewardobject->addRewardsLog(array(
                'rewardID' => $id,
                'action'=>"Create Reward",
				'name'=> $reward,
				'description' => $description,
				'rewardLimit' => $rewardLimit,
				'points' => $points,
				'category' => $category,
				'expiredate' => $expiredate,
				'actionDate' => $entrydate,
                'userID' => $userid
				
	
            ));
            

			
			$array=[
				'reward'=> $reward,
				'description'=> $description,
				'quantity' => $quantity,
				'rewardLimit'=> $rewardLimit,
				'points'=> $points,
				'category'=> $category,
				'expiredate'=> $expiredate,
				'entrydate'=> $entrydate,
				'quantity' => $quantity,
				// 'reward_img' => $data,
				'condition'=> $allcondition
			];

		} catch (Exception $e){
			echo $e->getMessage();
		}
	}else{
		$array = [
				'reward'=> $prewardnameerror,
				'description' => $descriptionerror,
				'rewardLimit' => $rewardLimiterror,
				'points' => $pointserror,
				'category' => $categoryerror,
				'expiredate' => $expiredateerror,
				'entrydate' => $entrydateerror,
				'quantity' => $quantityerror,
				//'condition'=> $allcondition
				
		];
	}
	echo json_encode($array);
}
?>
