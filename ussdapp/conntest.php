<html><head><title></title></head><body>
<?php	
	

$dbname = 'WidsDB';
$dbuser = 'root';
$dbpass = '';
$dbhost = 'localhost';
$conn = new mysqli($dbhost, $dbuser,$dbpass,$dbname);
        
        //$connectionStri    = new connectionStr();
        if($conn->connect_error){
			
			die("Connection Error" . $conn->connect_error);
			echo "Failed to connect";        
     }else{
     	echo "successful connection";
       
       // $connect ->query($queryStr);
        
     }
     
     $sql = "INSERT INTO SessionLog (MSISDN, SessionId, FromNode)
VALUES (1, '6v', 23)";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
     
     ?>
     </body></html>