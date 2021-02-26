<?php
class Database{
	//properties of class Database
	private static $_instance = null;
	private $_pdo, 
			$_query, 
			$_error = false, 
			$_results,
			$_count = 0,
			$_insertid;
			
	//Methods of class Database
	//get connection to database with PDO
	private function __construct(){
		try{
			$this->_pdo = new PDO('mysql:host='.Config::get('database/host').';dbname='.Config::get('database/db'),Config::get('database/username'),Config::get('database/password'));
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	//create instance for connection
	public static function getInstance(){
		if(!isset(self::$_instance)){
			self::$_instance = new Database();
		}
		return self::$_instance;
	}

	public function lastInsertId(){
		return $this->_pdo->lastinsertid();
	}
	
	//execute the sql statement and save to results variable
	public function query($sql, $params = array()){
		$this->_error = false;
		if($this->_query = $this->_pdo->prepare($sql)){
			$x = 1;
			if(count($params)){
				foreach($params as $param){
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}
			if($this->_query->execute()){
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
				
			}else{
				$this->_error = true;
			}
		}
		return $this;
	}

	public function queryall($sql = null){
		$this->_error = false;
		if($this->_query = $this->_pdo->prepare($sql)){

			if($this->_query->execute()){
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
				
			}else{
				$this->_error = true;
			}
		}
		return $this;
	}

	public function actionall($action, $table){
		$sql = "{$action} FROM {$table}";
		if(!$this->queryall($sql)->error()){
			return $this;
		}
		return false;
	}

	public function getall($table){
		return $this->actionall('SELECT *', $table);
	}

	//restructure the sql statement from function get and delete
	public function action($action, $table, $where = array()){
		if(count($where) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field 		= $where[0];
			$operator 	= $where[1];
			$value 		= $where[2];
			
			if(in_array($operator, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
				if(!$this->query($sql, array($value))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function actionOne($action, $table, $where1 = array(), $where2 = array()){
		if(count($where1) === 3 && count($where2) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field1 		= $where1[0];
			$operator1 		= $where1[1];
			$value1 		= $where1[2];

			$field2 		= $where2[0];
			$operator2 		= $where2[1];
			$value2 		= $where2[2];
			
			if(in_array($operator1, $operators) && in_array($operator2, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field1} {$operator1} ? AND {$field2} {$operator2} ?";
				if(!$this->query($sql, array($value1, $value2))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function actionTwo($action, $table, $where1 = array(), $where2 = array(), $where3){
		if(count($where1) === 3 && count($where2) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field1 		= $where1[0];
			$operator1 		= $where1[1];
			$value1 		= $where1[2];

			$field2 		= $where2[0];
			$operator2 		= $where2[1];
			$value2 		= $where2[2];
			
			if(in_array($operator1, $operators) && in_array($operator2, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field1} {$operator1} ? AND {$field2} {$operator2} ? AND verified = ?";
				if(!$this->query($sql, array($value1, $value2, $where3))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function action2($action, $table, $where1 = array(), $where2 = array(), $where3 = array()){
		if(count($where1) === 3 && count($where2) === 3 && count($where3) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field1 		= $where1[0];
			$operator1 		= $where1[1];
			$value1 		= $where1[2];

			$field2 		= $where2[0];
			$operator2 		= $where2[1];
			$value2 		= $where2[2];

			$field3 		= $where3[0];
			$operator3 		= $where3[1];
			$value3 		= $where3[2];
			
			if(in_array($operator1, $operators) && in_array($operator2, $operators) && in_array($operator3, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field1} {$operator1} ? AND {$field2} {$operator2} ? AND {$field3} {$operator3} ?";
				if(!$this->query($sql, array($value1, $value2, $value3))->error()){
					return $this;
				}
			}
		}
		return false;
	}
	
	public function action2_1($action, $table, $where1 = array(), $where2 = array(), $where3 = array()){
		if(count($where1) === 3 && count($where2) === 3 && count($where3) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field1 		= $where1[0];
			$operator1 		= $where1[1];
			$value1 		= $where1[2];

			$field2 		= $where2[0];
			$operator2 		= $where2[1];
			$value2 		= $where2[2];

			$field3 		= $where3[0];
			$operator3 		= $where3[1];
			$value3 		= $where3[2];
			
			if(in_array($operator1, $operators) && in_array($operator2, $operators) && in_array($operator3, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field1} {$operator1} ? AND ({$field2} {$operator2} ? OR {$field3} {$operator3} ?)";
				if(!$this->query($sql, array($value1, $value2, $value3))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function action3($action, $table, $where1 = array(), $where2 = array(), $where3 = array(), $where4 = array()){
		if(count($where1) === 3 && count($where2) === 3 && count($where3) === 3 && count($where4) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field1 		= $where1[0];
			$operator1 		= $where1[1];
			$value1 		= $where1[2];

			$field2 		= $where2[0];
			$operator2 		= $where2[1];
			$value2 		= $where2[2];

			$field3 		= $where3[0];
			$operator3 		= $where3[1];
			$value3 		= $where3[2];

			$field4 		= $where4[0];
			$operator4 		= $where4[1];
			$value4 		= $where4[2];
			
			if(in_array($operator1, $operators) && in_array($operator2, $operators) && in_array($operator3, $operators) && in_array($operator4, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field1} {$operator1} ? AND {$field2} {$operator2} ? AND ({$field3} {$operator3} ? AND {$field4} {$operator4} ?)";
				if(!$this->query($sql, array($value1, $value2, $value3, $value4))->error()){
					return $this;
				}
			}
		}
		return false;
	}
	
	public function action3_1($action, $table, $where1 = array(), $where2 = array(), $where3 = array(), $where4 = array(), $where5 = array(), $where6 = array()){
		if(count($where1) === 3 && count($where2) === 3 && count($where3) === 3 && count($where4) === 3 && count($where5) === 3 && count($where6) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field1 		= $where1[0];
			$operator1 		= $where1[1];
			$value1 		= $where1[2];

			$field2 		= $where2[0];
			$operator2 		= $where2[1];
			$value2 		= $where2[2];

			$field3 		= $where3[0];
			$operator3 		= $where3[1];
			$value3 		= $where3[2];

			$field4 		= $where4[0];
			$operator4 		= $where4[1];
			$value4 		= $where4[2];

			$field5 		= $where5[0];
			$operator5 		= $where5[1];
			$value5 		= $where5[2];

			$field6 		= $where6[0];
			$operator6 		= $where6[1];
			$value6 		= $where6[2];
			
			if(in_array($operator1, $operators) && in_array($operator2, $operators) && in_array($operator3, $operators) && in_array($operator4, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field1} {$operator1} ? AND {$field2} {$operator2} ? AND (({$field3} {$operator3} ? AND {$field4} {$operator4} ?) OR ({$field5} {$operator5} ? AND {$field6} {$operator6} ?))";
				if(!$this->query($sql, array($value1, $value2, $value3, $value4, $value5, $value6))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function action4($action, $table, $where1 = array(), $where2 = array(), $where3 = array(), $where4 = array(), $where5 = array()){
		if(count($where1) === 3 && count($where2) === 3 && count($where3) === 3 && count($where4) === 3 && count($where5) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field1 		= $where1[0];
			$operator1 		= $where1[1];
			$value1 		= $where1[2];

			$field2 		= $where2[0];
			$operator2 		= $where2[1];
			$value2 		= $where2[2];

			$field3 		= $where3[0];
			$operator3 		= $where3[1];
			$value3 		= $where3[2];

			$field4 		= $where4[0];
			$operator4 		= $where4[1];
			$value4 		= $where4[2];

			$field5 		= $where5[0];
			$operator5 		= $where5[1];
			$value5 		= $where5[2];
			
			if(in_array($operator1, $operators) && in_array($operator2, $operators) && in_array($operator3, $operators) && in_array($operator4, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field1} {$operator1} ? AND {$field2} {$operator2} ? AND ({$field3} {$operator3} ? AND {$field4} {$operator4} ? AND {$field5} {$operator5} ?)";
				if(!$this->query($sql, array($value1, $value2, $value3, $value4, $value5))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function actionDesc($action, $table, $where = array(), $where2){
		if(count($where) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field 		= $where[0];
			$operator 	= $where[1];
			$value 		= $where[2];
			
			if(in_array($operator, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? ORDER BY {$where2} DESC";
				if(!$this->query($sql, array($value))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function actionDescN($action, $table, $where = array(), $where2, $where3 = array(), $where4){
		if(count($where) === 3 && count($where3) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field 		= $where[0];
			$operator 	= $where[1];
			$value 		= $where[2];

			$field3 		= $where3[0];
			$operator3 		= $where3[1];
			$value3 		= $where3[2];
			
			if(in_array($operator, $operators) && in_array($operator3, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field3} {$operator3} ? AND {$where2} NOT IN (SELECT {$where4} FROM {$table} WHERE {$field} {$operator} ? ) GROUP BY {$where2}";
				if(!$this->query($sql, array($value, $value3))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function actionGroup($action, $table, $where = array(), $where2){
		if(count($where) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field 		= $where[0];
			$operator 	= $where[1];
			$value 		= $where[2];
			
			if(in_array($operator, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? GROUP BY {$where2}";
				if(!$this->query($sql, array($value))->error()){
					return $this;
				}
			}
		}
		return false;
	}


	public function actionPcom($action, $table, $where1 = array(), $where2 = array(), $where3 = array()){
		if(count($where1) === 3 && count($where2) === 3 && count($where3) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field1 		= $where1[0];
			$operator1 		= $where1[1];
			$value1 		= $where1[2];

			$field2 		= $where2[0];
			$operator2 		= $where2[1];
			$value2 		= $where2[2];

			$field3 		= $where3[0];
			$operator3 		= $where3[1];
			$value3 		= $where3[2];
			
			if(in_array($operator1, $operators) && in_array($operator2, $operators) && in_array($operator3, $operators)){
				$sql = "{$action} FROM {$table} WHERE parent_comment_id = '0' AND ( {$field1} {$operator1} ? OR {$field2} {$operator2} ? ) AND {$field3} {$operator3} ?  ORDER BY comment_id DESC";
				if(!$this->query($sql, array($value1, $value2, $value3))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function actionCcom($action, $table, $where1 = array()){
		if(count($where1) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field1 		= $where1[0];
			$operator1 		= $where1[1];
			$value1 		= $where1[2];

			if(in_array($operator1, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field1} {$operator1} ?";
				if(!$this->query($sql, array($value1))->error()){
					return $this;
				}
			}
		}
		return false;
	}
	
	public function actionE($action, $table, $where1 = array(), $where2 = array(), $where3 = array()){
		if(count($where1) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field1 		= $where1[0];
			$operator1 		= $where1[1];
			$value1 		= $where1[2];

			$field2 		= $where2[0];
			$operator2 		= $where2[1];
			$value2 		= $where2[2];

			$field3 		= $where3[0];
			$operator3 		= $where3[1];
			$value3 		= $where3[2];
			

			
			if(in_array($operator1, $operators) && in_array($operator2, $operators) && in_array($operator3, $operators)){
				$sql = "{$action} FROM {$table} WHERE ({$field1} {$operator1} ? OR {$field2} {$operator2} ?) AND {$field3} {$operator3} ?";
				if(!$this->query($sql, array($value1, $value2, $value3))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function actionsum($action, $table, $where = array()){
		if(count($where) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field 		= $where[0];
			$operator 	= $where[1];
			$value 		= $where[2];
			
			if(in_array($operator, $operators)){
				$sql = "{$action} AS totalsize FROM {$table} WHERE {$field} {$operator} ?";
				if(!$this->query($sql, array($value))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function actionGetKPITotalYear($action, $table, $where1 = array(), $where2 = array()){
		if(count($where1) === 3 && count($where2) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field1 		= $where1[0];
			$operator1 		= $where1[1];
			$value1 		= $where1[2];

			$field2 		= $where2[0];
			$operator2 		= $where2[1];
			$value2 		= $where2[2];
			
			if(in_array($operator1, $operators) && in_array($operator2, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field1} {$operator1} ? AND {$field2} {$operator2} ? GROUP BY month";
				if(!$this->query($sql, array($value1, $value2))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function actionProgress($action, $table, $where = array(), $where2, $where3 = array(), $where4){
		if(count($where) === 3 && count($where3) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field 		= $where[0];
			$operator 	= $where[1];
			$value 		= $where[2];

			$field3 		= $where3[0];
			$operator3 		= $where3[1];
			$value3 		= $where3[2];
			
			if(in_array($operator, $operators) && in_array($operator3, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? AND {$field3} {$operator3} ? AND {$where2} IN (SELECT MAX({$where2}) FROM {$table}  GROUP BY {$where4})";
				if(!$this->query($sql, array($value, $value3))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function actionProgressDate($action, $table, $where = array(), $where2, $where3 = array(), $where4, $where5 = array()){
		if(count($where) === 3 && count($where3) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field 		= $where[0];
			$operator 	= $where[1];
			$value 		= $where[2];

			$field3 		= $where3[0];
			$operator3 		= $where3[1];
			$value3 		= $where3[2];

			$field5 		= $where5[0];
			$operator5 		= $where5[1];
			$value5 		= $where5[2];
			
			if(in_array($operator, $operators) && in_array($operator3, $operators) && in_array($operator5, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? AND {$field3} {$operator3} ? AND {$field5} {$operator5} ? AND {$where2} IN (SELECT MAX({$where2}) FROM {$table}  GROUP BY {$where4})";
				if(!$this->query($sql, array($value, $value3, $value5))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function actionProgressDateAll($action, $table, $where = array(), $where3 = array(), $where4, $where5 = array()){
		if(count($where) === 3 && count($where3) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field 		= $where[0];
			$operator 	= $where[1];
			$value 		= $where[2];

			$field3 		= $where3[0];
			$operator3 		= $where3[1];
			$value3 		= $where3[2];

			$field5 		= $where5[0];
			$operator5 		= $where5[1];
			$value5 		= $where5[2];
			
			if(in_array($operator, $operators) && in_array($operator3, $operators) && in_array($operator5, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? AND {$field3} {$operator3} ? AND {$field5} {$operator5} ?";
				if(!$this->query($sql, array($value, $value3, $value5))->error()){
					return $this;
				}
			}
		}
		return false;
	}


	
	//select function and pass to function action

	public function getProgress($table, $where1, $where2, $where3, $where4){
		return $this->actionProgress('SELECT *', $table, $where1, $where2, $where3, $where4);
	}

	public function getProgressDate($table, $where1, $where2, $where3, $where4, $where5){
		return $this->actionProgressDate('SELECT *', $table, $where1, $where2, $where3, $where4, $where5);
	}

	public function getProgressDateAll($table, $where1, $where3, $where4, $where5){
		return $this->actionProgressDateAll('SELECT *', $table, $where1, $where3, $where4, $where5);
	}

	public function getYearKPI($table, $where1,$where2){
		return $this->actionGetKPITotalYear('SELECT sum(progress) AS progress,sum(weightage) as weightage,month,year,assignTo', $table, $where1,$where2);
	}

	public function getsum($table , $where){
		return $this->actionsum('SELECT SUM(size)', $table, $where);
	}

	public function get($table, $where){
		return $this->action('SELECT *', $table, $where);
	}
	
	public function getE($table, $where1, $where2, $where3){
		return $this->actionE('SELECT *', $table, $where1, $where2, $where3);
	}

	public function getPcomm($table, $where1, $where2, $where3){
		return $this->actionPcom('SELECT *', $table, $where1, $where2, $where3);
	}

	public function getCcomm($table, $where1){
		return $this->actionCcom('SELECT *', $table, $where1);
	}

	public function getOne($table, $where1, $where2){
		return $this->actionOne('SELECT *', $table, $where1, $where2);
	}

	public function getTwo($table, $where1, $where2, $where3){
		return $this->actionTwo('SELECT *', $table, $where1, $where2, $where3);
	}

	public function get2($table, $where1, $where2, $where3){
		return $this->action2('SELECT *', $table, $where1, $where2, $where3);
	}
	
	public function get2_1($table, $where1, $where2, $where3){
		return $this->action2_1('SELECT *', $table, $where1, $where2, $where3);
	}

	public function get3($table, $where1, $where2, $where3, $where4){
		return $this->action3('SELECT *', $table, $where1, $where2, $where3, $where4);
	}
	
	public function get3_1($table, $where1, $where2, $where3, $where4, $where5, $where6){
		return $this->action3_1('SELECT *', $table, $where1, $where2, $where3, $where4, $where5, $where6);
	}

	public function get4($table, $where1, $where2, $where3, $where4, $where5){
		return $this->action4('SELECT *', $table, $where1, $where2, $where3, $where4, $where5);
	}

	public function getDesc($table, $where1, $where2){
		return $this->actionDesc('SELECT *', $table, $where1, $where2);
	}

	public function getGroup($table, $where1, $where2, $where3, $where4){
		return $this->actionDescN('SELECT *', $table, $where1, $where2, $where3, $where4);
	}
	
	public function getGroupS($table, $where1, $where2){
		return $this->actionGroup('SELECT *', $table, $where1, $where2);
	}

	
	
	//delete function and pass to function action
	public function delete($table, $where){
		return $this->action('DELETE ', $table, $where);
	}
	
	//insert function
	public function insert($table, $fields = array()){
		$keys = array_keys($fields);
		$values = null;
		$x = 1;

		foreach($fields as $field) {
			$values .= '?';
			if($x < count($fields)) {
				$values .= ', ';
			}
			$x++;
		}

		$sql = "INSERT INTO {$table} (`" . implode('`,`' , $keys) . "`) VALUES ({$values})";

		if(!$this->query($sql, $fields)->error()) {
			return true;
		}
		return false;
	}
	
	//update function
	public function update($table, $id, $fields, $idname){
		$set = '';
		$x = 1;

		foreach($fields as $name => $value) {
		  $set .= "{$name} = ?";
		  if($x < count($fields)) {
			$set .= ', ';
		  }
		  $x++;
		}

		$sql = "UPDATE {$table} SET {$set} WHERE {$idname} = {$id}";

		if (!$this->query($sql, $fields)->error()) {
		  return true;
		}
		return false;
	}

	//get results
	public function results(){
		return $this->_results;
	}
	
	public function first(){
		return $this->results()[0];
	}
	
	//get errors
	public function error(){
		return $this->_error;
	}
	
	//get count 
	public function count(){
		return $this->_count;
	}

	public function sumbase($table, $where){
		return $this->action1('SELECT baselineID, categoryID, (jan+feb+mar+apr+may+jun+jul+aug+sept+oct+nov+dece) ', $table, $where);
	}

	public function leftJoin($table1, $table2, $where = array(), $action = 'SELECT') {

        if(count($where) === 3){
            $operators = array('=', '!=', '>', '<', '>=', '<=');

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if(in_array($operator, $operators)) {

            }

            $sql = "{$action} category.category,baseline.baselineID,SUM(baseline.targetval) AS targetvalue,SUM(baseline.jan) AS jan, SUM(baseline.feb) AS feb ,SUM(baseline.mar) AS mar,SUM(baseline.apr) AS apr,SUM(baseline.may) AS may,SUM(baseline.jun) AS jun,SUM(baseline.jul) AS jul,SUM(baseline.aug) AS aug,SUM(baseline.sept) AS sept,SUM(baseline.oct)AS oct,SUM(baseline.nov) AS nov,SUM(baseline.dece) AS dece FROM {$table1},{$table2} WHERE {$table1}.categoryID = {$table2}.categoryID AND {$field} {$operator} ? GROUP BY category";

            if(!$this->query($sql, array($value))->error()) {
                return $this;
            }
        } 

    }

   public function claimJoin($table1, $table2, $where = array(), $action = 'SELECT') {

        if(count($where) === 3){
            $operators = array('=', '!=', '>', '<', '>=', '<=');

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if(in_array($operator, $operators)) {
            	$sql = "{$action} m.reward, m.description, m.rewardLimit, m.points, m.category, m.expiredate, m.reward_img, c.date FROM {$table1} c, {$table2} m WHERE c.rewardID = m .rewardID and m.{$field} {$operator} ?";

            if(!$this->query($sql, array($value))->error()) {
                return $this;
            }

            }            
        } 

    }

	public function action1($action, $table, $where = array()){
		if(count($where) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field 		= $where[0];
			$operator 	= $where[1];
			$value 		= $where[2];
			
			if(in_array($operator, $operators)){
				$sql = "{$action} AS total FROM {$table} WHERE {$field} {$operator} ?";
				if(!$this->query($sql, array($value))->error()){
					return $this;
				}
			}
		}
		return false;
	}
	
	public function actionalllimit($action, $table, $start, $per_page){
		$sql = "{$action} FROM {$table} LIMIT $start, $per_page";
		if(!$this->queryall($sql)->error()){
			return $this;
		}
		return false;
	}

	public function getalllimit($table , $start, $per_page){
		return $this->actionalllimit('SELECT *', $table, $start, $per_page);
	}

	public function actionlimit($action,$table, $select){


		$sql = "{$action} FROM {$table} WHERE country IN {$select}";
		if(!$this->queryall($sql)->error()){
			return $this ;
		}
		return false ;
	}

	public function getlimit($table , $select){
		return $this->actionlimit('SELECT *', $table, $select);
	}

	// PRS part 

	public function actionOrder($action, $table, $where = array(), $select) {

        if(count($where) === 3){
            $operators = array('=', '!=', '>', '<', '>=', '<=');

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if(in_array($operator, $operators)) {            

                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? ORDER BY {$select} DESC LIMIT 5";

            if(!$this->query($sql, array($value))->error()) {
                return $this;
            }
		}
		} 
		

    }

    	public function getOrder($table, $where, $select){
		return $this->actionOrder('SELECT *', $table, $where, $select);
	}
	
	public function actionOrder2($action, $table, $where = array(), $select) {

        if(count($where) === 3){
            $operators = array('=', '!=', '>', '<', '>=', '<=');

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if(in_array($operator, $operators)) {            }

                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? ORDER BY {$select} < CURDATE() ASC";

            if(!$this->query($sql, array($value))->error()) {
                return $this;
            }

        } 

    }
    public function getOrder2($table, $where, $select){
		return $this->actionOrder2('SELECT *', $table, $where, $select);
	}

	public function getGroupY($table, $where1, $where2){
		return $this->actionGroupY('SELECT ', $table, $where1, $where2);
	}

	
	public function actionGroupY($action, $table, $where = array(), $where2){
		if(count($where) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field 		= $where[0];
			$operator 	= $where[1];
			$value 		= $where[2];
			
			if(in_array($operator, $operators)){
				$sql = "{$action}   {$where2} AS year FROM {$table} WHERE {$field} {$operator} ? GROUP BY {$where2}";
				if(!$this->query($sql, array($value))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function actionOrder3($action, $table, $where1 = array(), $where2 = array(), $select){
		if(count($where1) === 3 && count($where2) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field1 		= $where1[0];
			$operator1 		= $where1[1];
			$value1 		= $where1[2];

			$field2 		= $where2[0];
			$operator2 		= $where2[1];
			$value2 		= $where2[2];
			
			if(in_array($operator1, $operators) && in_array($operator2, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field1} {$operator1} ? AND {$field2} {$operator2} ? ORDER BY {$select} < CURDATE() ASC";
				if(!$this->query($sql, array($value1, $value2))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function getOrder3($table, $where1, $where2, $select){
		return $this->actionOrder3('SELECT *', $table, $where1, $where2, $select);
	}

	public function claimJoinTwo($table1, $table2, $where1 = array(), $where2 = array(), $action = 'SELECT' ){
        if(count($where1) === 3 && count($where2) === 3){
            $operators = array('=','>','<','>=','<=');

            $field1         = $where1[0];
            $operator1         = $where1[1];
            $value1         = $where1[2];

            $field2         = $where2[0];
            $operator2         = $where2[1];
            $value2         = $where2[2];

            if(in_array($operator1, $operators) && in_array($operator2, $operators)){
                $sql = "{$action} m.reward, m.description, m.rewardLimit, m.points, m.category, m.expiredate, m.reward_img, c.date FROM {$table1} c, {$table2} m WHERE c.rewardID = m.rewardID and c.{$field1} {$operator1} ? AND m.{$field2} {$operator2} ?";
                if(!$this->query($sql, array($value1, $value2))->error()){
                    return $this;
                }
            }
        }
        return false;
    }

}
?>