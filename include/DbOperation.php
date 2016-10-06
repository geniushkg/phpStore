<?php
 
class DbOperation
{
    //Database connection link
    private $con;
 
    //Class constructor
    function __construct()
    {
        //Getting the DbConnect.php file
        require_once dirname(__FILE__) . '/DbConnect.php';
 
        //Creating a DbConnect object to connect to the database
        $db = new DbConnect();
 
        //Initializing our connection link of this class
        //by calling the method connect of DbConnect class
        $this->con = $db->connect();
    }
	
	//todo: add methods to fetch debt hours for given userid

	//todo: add method to add new userid and debt hours for new user
	    // this will create a new user with default 10hours debt 
	    public function createUserWithDebt($userId){
 
        //First we will check whether the student is already registered or not
        if (!$this->isUserExits($userId)) {
           
            //Crating an statement
            $stmt = $this->con->prepare("INSERT INTO students(name, username, password, api_key) values(?, ?, ?, ?)");
 
            //Binding the parameters
            $stmt->bind_param("ssss", $name, $username, $password, $apikey);
 
            //Executing the statment
            $result = $stmt->execute();
 
            //Closing the statment
            $stmt->close();
 
            //If statment executed successfully
            if ($result) {
                //Returning 0 means student created successfully
                return 0;
            } else {
                //Returning 1 means failed to create student
                return 1;
            }
        } else {
            //returning 2 means user already exist in the database
            return 2;
        }
    }
	//todo: add method to modify debt hours for given user id
	
	
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
 
}

?>