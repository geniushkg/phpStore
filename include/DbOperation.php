<?php
 
class DbOperation {
    //Database connection link
    private $con;
 
    //Class constructor
    function __construct() {
        //Getting the DbConnect.php file
        require_once dirname(__FILE__) . '/DbConnect.php';
 
        //Creating a DbConnect object to connect to the database
        $db = new DbConnect();
 
        //Initializing our connection link of this class
        //by calling the method connect of DbConnect class
        $this->con = $db->connect();
    }
	
		
		
		//this method will return debt for given userid
		public function getDebt($userId){
			$stmt = $this->con->prepare("SELECT debt_hour FROM userdata WHERE user_id=?");
			$stmt->bind_param("i",$userId);
			$stmt->execute();
			//Getting the user result array
			$user = $stmt->get_result()->fetch_assoc();
			$stmt->close();
			//returning the user
			return $user;
		}

		
	    // this will create a new user with  debt 
	    public function createUserWithDebt($userId,$debt_hour){
 
        //First we will check whether the student is already registered or not
			if (!$this->isUserExits($userId)) {
           
            //Crating an statement
            $stmt = $this->con->prepare("INSERT INTO userdata(user_id, debt_hour) values(?, ?)");
 
            //Binding the parameters
            $stmt->bind_param("ii", $userId,$debt_hour);
 
            //Executing the statment
            $result = $stmt->execute();
 
            //Closing the statment
            $stmt->close();
 
				//If statment executed successfully
				if ($result) {
					//Returning 0 means user created successfully
					return 0;
				} else {
					//Returning 1 means failed to create user
					return 1;
				}
			} else {
            //returning 2 means user already exist in the database
            return 2;
			}
		}
		
		//this method will update given userid debt
		public function modifyDebt($userId,$debt){
			$stmt = $this->con->prepare("UPDATE debt_hour SET debt_hour=? WHERE user_id=?");
			$stmt->bind_param("ii",$debt,$userId);
			$stmt->execute();
				if($this->db->affected_rows() >= 0){ 
					return 0;
				}else{
					return 1;
				}
		}
	
	//todo: add method to check if user already exits
	private function isUserExits($userId){
		$stmt = $this->con->prepare("SELECT user_id from userdata WHERE user_id = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
	}
} ?>