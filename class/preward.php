<?php
class Preward{
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

public function createpreward($fields = array()){
	if(!$this->_db->insert('merit_rewards', $fields)){
		throw new Exception("Error Processing Request");
		
	}
}

public function addRewardsLog($fields = array()){
	if(!$this->_db->insert('logmerit_rewards', $fields)){
		throw new Exception("Error Processing Request");
		
	}
}
public function insertpointlog($fields = array()){
	if(!$this->_db->insert('logpoints', $fields)){
		throw new Exception("Error Processing Request");
		
	}
}


public function searchAllReward($id = null, $idfrom = null){
		if($id){
			$field = (is_numeric($id)) ? $idfrom : null;
			$data = $this->_db->get('merit_rewards', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
}

public function editpreward($fields = array(), $id = null){
	if(!$this->_db->update('merit_rewards', $id, $fields, 'rewardID')){
		throw new Exception("There is an error while updating kpi.");
		
	}
}

public function searchRewardID($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'rewardID' : null;
			$data = $this->_db->get('merit_rewards', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
}

public function deletepreward($id = null){
    if($id){
        $field = (is_numeric($id)) ? 'rewardID' : 'reward';
        $data = $this->_db->delete('merit_rewards', array($field, '=', $id));
    }
    return "failed delete ";
}

public function getCategory($id = null, $idfrom = null, $category = null){
	
	if($id and $category){
		$field1 = (is_numeric($id)) ? $idfrom : null;
		$field2 = ($category) ? 'category' : null;

		$data = $this->_db->getOrder3('merit_rewards', array($field1, '=',$id), array($field2, '=',$category), 'expiredate');
		if($data->count()){

			$this->_data = $data->results();
			return $this->_data;
		}
	}	

}

public function getCategorylog($id = null, $action_name = null){
	
	if($id and $action_name){
		$field1 = (is_numeric($id)) ? 'userID' : null;
		$field2 = ($action_name) ? 'action_name' : null;

		$data = $this->_db->getOrder3('logpoints', array($field1, '=',$id), array($field2, '=',$action_name), 'actionDate');
		if($data->count()){

			$this->_data = $data->results();
			return $this->_data;
		}
	}	

}

public function searchAllCorReward($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'corporateID' : null;
			$data = $this->_db->get('merit_rewards', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
}

public function searchAllComReward($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'companyID' : null;
			$data = $this->_db->get('merit_rewards', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
}

public function insertclaimreward($fields = array()){
	if(!$this->_db->insert('claim_merit_reward', $fields)){
		throw new Exception("Error Processing Request");
		
	}
}

public function searchPointReward($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'userID' : null;
			$data = $this->_db->get('merit_points', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
}

public function searchPointReward2($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'userID' : null;
			$data = $this->_db->get('merit_points', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
}

public function getclaimreward($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'userID' : null;
			$data = $this->_db->claimJoin('claim_merit_reward', 'merit_rewards', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}

}

public function getcategoryclaimed($userID = null, $category = null){
        if($userID and $category){
        $field1 = (is_numeric($userID))? 'userID':null;
        $field2 = ($category) ? 'category' : 'category';

        $data = $this->_db->claimJoinTwo('claim_merit_reward', 'merit_rewards', array($field1, '=', $userID), array($field2, '=', $category));

        if($data->count()){
                $this->_data = $data->results();
                return $this->_data;
            }
    }

}

public function getusercategoryclaimed($userID = null, $category = null){
        if($userID and $category){
        $field1 = (is_numeric($userID))? 'userID':null;
        $field2 = ($category) ? 'category' : 'category';

        $data = $this->_db->claimJoinTwo('claim_merit_reward', 'merit_rewards', array($field1, '=', $userID), array($field2, '=', $category));

        if($data->count()){
                $this->_data = $data->results();
                return $this->_data;
            }
    }

}

public function searchAllClaim($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'rewardID' : null;
			$data = $this->_db->get('claim_merit_reward', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
}

public function searchAllCorClaim($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'corporateID' : null;
			$data = $this->_db->get('claim_merit_reward', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
}

public function searchAllComClaim($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'companyID' : null;
			$data = $this->_db->get('claim_merit_reward', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
}

public function searchAllClaim2($id = null, $corporateID = null){
		if($id and $corporateID){
			$field1 = (is_numeric($id)) ? 'rewardID' : null;
			$field2 = (is_numeric($corporateID)) ? 'corporateID' : null;
			$data = $this->_db->getOne('claim_merit_reward', array($field1, '=', $id), array($field2, '=', $corporateID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
}
public function searchAllClaim5($id = null, $userID = null){
	if($id and $userID){
		$field1 = (is_numeric($id)) ? 'rewardID' : null;
		$field2 = (is_numeric($userID)) ? 'userID' : null;
		$data = $this->_db->getOne('claim_merit_reward', array($field1, '=', $id), array($field2, '=', $userID));
		if($data->count()){
			$this->_data = $data->results();
			return $this->_data;
		}
	}
}

public function searchAllClaim4($id = null, $companyID = null){
	if($id and $companyID){
		$field1 = (is_numeric($id)) ? 'rewardID' : null;
		$field2 = (is_numeric($corporateID)) ? 'companyID' : null;
		$data = $this->_db->getOne('claim_merit_reward', array($field1, '=', $id), array($field2, '=', $companyID));
		if($data->count()){
			$this->_data = $data->results();
			return $this->_data;
		}
	}
}

public function searchAllClaim3($id = null){
	if($id){
		$field = (is_numeric($id)) ? 'claim_rewardID' : null;
		$data = $this->_db->get('claim_merit_reward', array($field, '=', $id));
		if($data->count()){
			$this->_data = $data->first();
			return $this->_data;
		}
	}
}


public function getAffPoint($id = null){
	
		if($id){
			$field1 = (is_numeric($id)) ? 'corporateID' : null;
			$data = $this->_db->claimJoin1('merit_rewards', 'merit_points', array($field1, '=', $id));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}

}

public function getAffPoint2($id = null){
		if($id){
			$field1 = (is_numeric($id)) ? 'corporateID' : null;
			$data = $this->_db->get('merit_rewards', array($field1, '=', $id));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
}

public function updatepoint($fields = array(), $id = null){
	if(!$this->_db->update('merit_points', $id, $fields, 'pointID')){
		throw new Exception("There is an error while updating kpi.");
		
	}
}

public function updateclaimed($fields = array(), $id = null){
	if(!$this->_db->update('claim_merit_reward', $id, $fields, 'claim_rewardID')){
		throw new Exception("There is an error while updating reward.");
		
	}
}

public function searchAllCorKPIReward($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'corporateID' : null;
			$data = $this->_db->get('rewardskpi', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
}




public function searchChart($id=null){
    if($id){
        // $field = (is_numeric($companyID)) ? 'companyID' : null;
        $field = (is_numeric($id)) ? 'companyID' : null;
        $data = $this->_db->getDesc('claim_merit_reward', array($field, '=', $id), 'date');
        if($data->count()){
            $this->_data = $data->results();
            return $this->_data;
        }
    }
}


public function searchChart2($id=null){
    if($id){
        // $field = (is_numeric($companyID)) ? 'companyID' : null;
        $field = (is_numeric($id)) ? 'corporateID' : null;
        $data = $this->_db->getDesc('claim_merit_reward', array($field, '=', $id), 'date');
        if($data->count()){
            $this->_data = $data->results();
            return $this->_data;
        }
    }
}


public function searchChart3($id=null){
    if($id){
        // $field = (is_numeric($companyID)) ? 'companyID' : null;
        $field = (is_numeric($id)) ? 'corporateID' : null;
        $data = $this->_db->getGroupY('claim_merit_reward', array($field, '=', $id), "year(date)");
        if($data->count()){
            $this->_data = $data->results();
            return $this->_data;
        }
    }
}

public function searchPointReward3($id = null, $idfrom = null){
	if($id){
		$field = (is_numeric($id)) ? $idfrom : null;
		$data = $this->_db->getOrder('merit_points', array($field, '=', $id), 'totalpoint');
		if($data->count()){
			$this->_data = $data->results();
			return $this->_data;
		}
	}
}

public function searchChart4($id=null){
    if($id){
        // $field = (is_numeric($companyID)) ? 'companyID' : null;
        $field = (is_numeric($id)) ? 'companyID' : null;
        $data = $this->_db->getGroupY('claim_merit_reward', array($field, '=', $id),"year(date)");
        if($data->count()){
            $this->_data = $data->results();
            return $this->_data;
        }
    }
}

public function searchUserClaim($id = null,  $idfrom = null, $year = null){
	if($id and $year){
		$field1 = (is_numeric($id)) ? $idfrom : null;
		$field2 = (is_numeric($year)) ? 'YEAR(date)' : null;
		$data = $this->_db->getOne('claim_merit_reward', array($field1, '=', $id), array($field2, '=', $year));
		if($data->count()){
			$this->_data = $data->results();
			return $this->_data;
		}
	}
}


public function searchPointComReward($id = null){
	if($id){
		$field = (is_numeric($id)) ? 'companyID' : null;
		$data = $this->_db->get('merit_points', array($field, '=', $id));
		if($data->count()){
			$this->_data = $data->results();
			return $this->_data;
		}
	}
}
public function searchPointReward4($id = null){
	if($id){
		$field = (is_numeric($id)) ? 'pointID' : null;
		$data = $this->_db->get('merit_points', array($field, '=', $id));
		if($data->count()){
			$this->_data = $data->first();
			return $this->_data;
		}
	}
}

public function searchmreward($id = null, $idfrom = null){
	if($id){
		$field = (is_numeric($id)) ? $idfrom : null;
		$data = $this->_db->getOrder2('merit_rewards', array($field, '=', $id), 'expiredate');
		if($data->count()){
			$this->_data = $data->results();
			return $this->_data;
		}
	}
}

public function searchAllClaimMeritCor($id = null){
	if($id){
		$field = (is_numeric($id)) ? 'corporateID' : null;
		$data = $this->_db->get('claim_merit_reward', array($field, '=', $id));
		if($data->count()){
			$this->_data = $data->results();
			return $this->_data;
		}
	}
}


public function searchpointlog($id = null){
	if($id){
		$field = (is_numeric($id)) ? 'userID' : null;
		$data = $this->_db->getOrder2('logpoints', array($field, '=', $id), 'actionDate');
		if($data->count()){
			$this->_data = $data->results();
			return $this->_data;
		}
	}
}

}?>