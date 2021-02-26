<?php
class Rewards{
	private $_data, 
			$_db;


            public function __construct($id = null){
                $this->_db = Database::getInstance();
            }
            
            public function lastinsertid(){
                return $this->_db->lastinsertid();
            }
            
            public function data(){
                return $this->_data;
            }
            
            public static function exists(){
                return(!empty($this->_data)) ? true : false;
            }
            

public function addKpiRewards($fields = array()){
	if(!$this->_db->insert('rewardskpi', $fields)){
		throw new Exception("Error Processing Request");
		
	}
}


public function addKpiRewardsLog($fields = array()){
	if(!$this->_db->insert('logrewards_kpi', $fields)){
		throw new Exception("Error Processing Request");
		
	}
}




public function updateKpiRewards($fields = array(), $id = null){

	if (!$this->_db->update('rewardskpi', $id, $fields, 'rewardsKPI_ID')) {
	  throw new Exception('There was a problem updating rewards.');
	}
}



public function updateKpiRewardsLog($fields = array(), $id = null){

	if (!$this->_db->update('logrewards_kpi', $id, $fields, 'logrewards_KPI_ID')) {
	  throw new Exception('There was a problem updating rewards.');
	}
}

//guna dlm form

public function searchReward($id = null){
    if($id){
        $field = (is_numeric($id)) ? 'userID' : null;
        $data = $this->_db->get('rewardskpi', array($field, '=', $id));
        if($data->count()){
          //  $this->_data = $data->first();//satu data paling ats
            $this->_data = $data->results();
            return $this->_data;
        }
    }
}

public function deleteKpiRewards($id = null){
    if($id){
        $field = (is_numeric($id)) ? 'rewardsKPI_ID' : 'name';
        $data = $this->_db->delete('rewardskpi', array($field, '=', $id));
    }
    return "failed delete ";
}


// zara tambah function baruu


    public function searchClassOnly($id = null, $idfrom = null){
		if($id){
			$field = (is_numeric($id)) ? $idfrom : null;
			$data = $this->_db->getGroupS('rewardskpi', array($field, '=', $id), "class");
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
    }





    public function AllRewards($corporateID = null){
        if($corporateID){
            $field = (is_numeric($corporateID)) ? 'corporateID' : null;
            $data = $this->_db->get('rewardskpi', array($field, '=', $corporateID));
            if($data->count()){
                $this->_data = $data->results();
                return $this->_data;
            }
        }
    }





public function searchRewardbyClass($id= null, $idfrom=null){

    if($id){
        $field1 = (is_numeric($id)) ? $idfrom : null;
     

        $data = $this->_db->get('rewardskpi', array($field1, '=',$id));
        if($data->count()){
            $this->_data = $data->results();
            return $this->_data;
        }
    }
}



//searchrewardOnly untuk getkpireward by id
//guna first
public function searchRewardOnly($rewardsKPI_ID = null){
    if($rewardsKPI_ID){
        $field = (is_numeric($rewardsKPI_ID)) ? 'rewardsKPI_ID' : null;
        $data = $this->_db->get('rewardskpi', array($field, '=', $rewardsKPI_ID));
        if($data->count()){
            $this->_data = $data->first();
            return $this->_data;
        }
    }
}

public function searchClassClaim($companyID = null, $class=null){
    if($companyID){
        $field = (is_numeric($companyID)) ? 'companyID' : null;
        $field2 = ($class) ? 'class' : null;
        $data = $this->_db->getOne('rewardskpi', array($field, '=', $companyID), array($field2, '=', $class));
        if($data->count()){
            $this->_data = $data->first();
            return $this->_data;
        }
    }
}


public function searchForm($id = null){
    if($id){
        $field = (is_numeric($id)) ? 'scoreresultID' : null;
        $data = $this->_db->get('scoreresult', array($field, '=', $id));
        if($data->count()){
            $this->_data = $data->first();
            return $this->_data;
        }
    }
}


public function searchForm2($companyID = null, $year=null){
    if($companyID){
        $field = (is_numeric($companyID)) ? 'companyID' : null;
        $field2 = (is_numeric($year)) ? 'year' : null;
        $data = $this->_db->getOne('scoreresult', array($field, '=', $companyID), array($field2, '=', $year));
        if($data->count()){
            $this->_data = $data->results();
            return $this->_data;
        }
    }
}


public function updateStatus($fields = array(), $id = null){

	if (!$this->_db->update('scoreresult', $id, $fields, 'scoreresultID')) {
	  throw new Exception('There was a problem updating rewards.');
	}
}



public function searchAssignScore($companyID = null){
    if($companyID){
        $field = (is_numeric($companyID)) ? 'companyID' : 'email' ;
        $data = $this->_db->get('users', array($field, '=', $companyID));
        if($data->count()){
            $this->_data = $data->results();
            return $this->_data;
        }
    }
}

public function searchGrade($id = null){
    if($id){
        $field = (is_numeric($id)) ? 'userID' : null;
        $data = $this->_db->get('scoreresult', array($field, '=', $id));
        if($data->count()){
          //  $this->_data = $data->first();//satu data paling ats
            $this->_data = $data->first();
            return $this->_data;
        }
    }
}




}
?>