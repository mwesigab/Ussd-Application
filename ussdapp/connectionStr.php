<?php
# Fill our vars and run on cli
# $ php -f db-connect-test.php
 class connectionStr{    
public function __construct(){}

public function ConnectionFc(){
 $dbname = 'dissemination';
$dbuser = 'root';
$dbpass = 'Rc4@dm1n';
//$dbpass = '';
$dbhost = 'localhost';
$conn = new mysqli($dbhost, $dbuser,$dbpass,$dbname);
        
        
        if($conn->connect_error){
			
			die("Connection Error" . $conn->connect_error);
                        $conn = "";
                        return $conn;//->connect_error;
                          
		        
     }else{
         
 
          return $conn;
        
     }
}

}
?>
