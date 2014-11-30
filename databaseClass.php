<?php require_once('dbConfig.php'); ?>
<?php 
	
	class MySQLDB{
		
		private $connection;
		
		public function __construct(){
				$this->openConnection();
		}	
		public function openConnection(){
			$this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die(mysqli_error($this->connection));
			if (!$this->connection) {
			die("Failed to connect to MySQL:");
			}
		}
		public function closeConnection(){
			if(isset($this->connection)){
				mysqli_close($this->connection);
				unset($this->connection);	
			}	
		}
		public function get_result($sql, $returnType = 'array'){
			$query = mysqli_query($this->connection, $sql) or die(mysqli_error($this->connection));
			$this->confirm_query($query);
			if($returnType == "array"){
				$resultSet = mysqli_fetch_array($query) or die(mysqli_error($this->connection));
			} else if($returnType == "assoc"){
				$resultSet = mysqli_fetch_assoc($query);
			}
			return $resultSet;
		}
		public function query($sql){
			$result = mysqli_query($this->connection, $sql) or die(mysqli_error($this->connection));
			$this->confirm_query($result);
			return $result;
		}
		
		public function num_rows($resultSet){
			return mysqli_num_rows($resultSet);	
		}
		
		public function affected_rows(){
			return mysqli_affected_rows($this->connection);	
		}
		
		private function confirm_query($resultSet){
			if(!$resultSet){
				die('There was some error performing query ' .mysqli_error($this->connection));	
			}
		}
	}
	
	$db = new MySQLDB();
?>
