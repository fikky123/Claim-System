<?php

require_once 'core/init.php';
if (Input::exists()) {
    $delprewardID = Input::get('delprewardID');


    function exists($data){
        if(empty($data)){
            return "Required";
        }else{
            return "Valid";
        }
    }

    function CheckAllcondition($data1){
        if ($data1 === "Valid") {
            return "Passed";
        }else{
            return "Failed";
        }
    }

    // $delprIDerror = exists($delprewardID);
    // $delkpinameerror = exists($delname);

    
    

    // $allCondition = checkAllcondition();

    //if ($allCondition === "Passed") {
        // try{
            $delprewobj = new Preward();
            $delprewobj->deletepreward($delprewardID);

            $array = [ 
                'delprewardID' => $delprewardID,
                // "condition"=> $allCondition
                // "lastinsertid"=>$id
            ];


        // } catch (Exception $e){
        //     echo $e->getMessage();
        //}
    // }elseif ($allCondition === "Failed") {
    //     $array = [
    //             "delprewardID" => $delprIDerror,
    //             "condition"=> $allCondition
    //         ];
    // }
    echo json_encode($array);
}
?>