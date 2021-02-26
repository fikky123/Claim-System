<?php
require_once 'core/init.php';
if(Input::exists()){

    $currentuser= new User();
    $userid = $currentuser->data()->userID;
    $currentcompany = new User();
    $companyid = $currentcompany->data()->companyID;
    $currentcorporate= new User();
    $corporateid = $currentcorporate->data()->corporateID;
    
    
	$upreward = escape(Input::get('upreward'));
	$updesc = escape(Input::get('updesc'));
    $upLimit = escape(Input::get('upLimit'));
    $uppoints = escape(Input::get('uppoints'));
    $upcategory = escape(Input::get('upcategory'));
    $upexpdate = escape(Input::get('upexpdate'));
    $upentdate = escape(Input::get('upentdate'));
    $upquantity = escape(Input::get('upquantity'));
    $upreward_img = escape(Input::get('upreward_img'));
    $rewardID = Input::get('rewardID');




    $logrewarduser = new Preward();
    $value = $logrewarduser->searchRewardID($rewardID);
  
	$prevrewardname =$value->reward;
	$prevrewarddesc = $value->description;
    $prevrewardrewardlimit = $value->rewardLimit;
    $prevrewardpoints = $value->points;
    $prevrewardcategory = $value->category;
    $prevrewardexpiredate = $value->expiredate;


   
   if(!empty($_FILES['upreward_img']['name'])){
    $files = file_get_contents($_FILES['upreward_img']['tmp_name']);
    // print_r($files);
    }
    else{
    $files = null;
    }

	function exists($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}

    function checkAllCondition($data1,$data2,$data3,$data4,$data5,$data6,$data7, $data8){

		if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 ==="Valid" && $data5 ==="Valid" && $data6 ==="Valid" && $data7 === "Valid" && $data8 === "Valid"){
			return "Passed";
		}else{
			return "Failed";
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
      
    
    $uprewarderror = exists($upreward);
    $updescerror = exists($updesc);
    $upLimiterror = checkInt($upLimit);
    $uppointerror = checkInt($uppoints);
    $upcaterror = exists($upcategory);
    $upexpdateerror = exists($upexpdate);
    $upentdateerror = exists($upentdate);
    $upquantityerror = checkInt($upquantity);


    $allcondition = checkAllcondition($uprewarderror, $updescerror, $upLimiterror, $uppointerror, $upcaterror, $upexpdateerror, $upentdateerror, $upquantityerror);


	if($allcondition === "Passed"){

		try{
			$prewardobject = new Preward();

            if ($files == null){
			$prewardobject->editpreward(array(
				'reward'=>$upreward,
                'description'=>$updesc,
                'rewardLimit'=>$upLimit,
                'points'=>$uppoints,
                'category'=>$upcategory,
                'expiredate'=>$upexpdate,
                'entrydate'=>$upentdate,
                'userID' => $userid,
                'companyID' => $companyid,
                'corporateID' => $corporateid,
                'quantity' => $upquantity,
			), $rewardID);}

            else{
                $prewardobject->editpreward(array(
                'reward'=>$upreward,
                'description'=>$updesc,
                'rewardLimit'=>$upLimit,
                'points'=>$uppoints,
                'category'=>$upcategory,
                'expiredate'=>$upexpdate,
                'entrydate'=>$upentdate,
                'userID' => $userid,
                'companyID' => $companyid,
                'corporateID' => $corporateid,
                'quantity' => $upquantity,
                'reward_img' => $files,
            ), $rewardID);
            }

            $prewardobject = new preward();
			$prewardobject->addRewardsLog(array(
                'rewardID' => $rewardID,
                'action'=>"Update Reward",
                'name'=> $upreward,
                'previousName'=>$prevrewardname,
                'previousDescription'=>$prevrewarddesc,
                'description' => $updesc,
                'previousRewardLimit'=>$prevrewardrewardlimit,
                'rewardLimit' => $upLimit,
                'previousPoints'=>$prevrewardpoints,
                'points' => $uppoints,
                'previousCategory'=>$prevrewardcategory,
                'category' => $upcategory,
                'previousExpiredate'=>$prevrewardexpiredate,
				'expiredate' => $upexpdate,
				'actionDate' => $upexpdate,
                'userID' => $userid,
				
	
            ));









            $array=[
                'condition'=> $allcondition
            ];

		}catch (Exception $e){
			echo $e->getMessage();
		}

	}else{

		$array = [ 
            'reward' => $uprewarderror,
            'description' => $updescerror,
            'rewardLimit' => $upLimiterror,
            'points' => $uppointerror,
            'category'=>$upcaterror,
            'expiredate' => $upexpdateerror,
            'entrydate' => $upentdateerror,
            'rewardID'=>$rewardID,
            'quantity' => $upquantityerror,
            'condition'=> $allcondition
			];
	}
	echo json_encode($array);
}

?>