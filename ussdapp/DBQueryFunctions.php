<?php 
ob_start();
include_once 'connectionStr.php';
include_once 'smsApi.php';
include_once 'ussdresponsesender.php';
//include_once 'MoUssdReceiver.php';
//$receiver = new MoUssdReceiver();
//$smsApiObject = new smsApi();
//$connStrObject = new connectionStr();

 class DBQueryFunctions{

// 

public function __construct(){
    
    $this->smsApi = new smsApi;
    $this->connectionStr = new connectionStr;
    $this->ussdresponsesender = new ussdresponsesender;
    
}
function queryMenu($id){
    
   
   $queryStr = "Select Menus.menuDescription 
   from Menus where menuId= '".mysql_real_escape_string($id)."'"; 
    $result = mysql_query($queryStr);
    $result_array = array();
    if($result !=""){
   while($row = mysql_fetch_assoc($result)){
       $result_array[] = $row;
       $stringToPrint = implode(",", $result_array);
       return $stringToPrint;
       }
  
    }
    
//mysql_close($connect); 

 } 

public function LogUssdTran( $msisdn, $sessionID, $levelVal, $InstVal){
    
    
    try{
        
//        $queryStr1 = "SELECT * FROM ussdtransaction WHERE Msisdn = '$msisdn' AND SessionId = '$sessionID'";
//
//        $status = checkIfSessionAlreadyLogged($queryStr1);
//        
//        if($status == "1"){
//            
//            $queryStr = "INSERT INTO  ussdtransaction (Msisdn,SessionId,Level0) VALUES ('$msisdn','$sessionID','$InstVal')";
//        
//        } else {
        
            $queryStr = "UPDATE  ussdtransaction SET Level0 = '$InstVal' WHERE Msisdn = '$msisdn' AND SessionId = '$sessionID' ";
        
       // }
        
        $result = $this->Insertion_UpdateQuerys($queryStr);
        //echo $result;
        
       
        }catch(Exception $ex){
        	
            
            }
 
    }
    
    public function LogUssdmaintran( $msisdn, $sessionID){
    
        $queryStr = "";
        $resultFn = "";
    
    try{
       
        $queryStr1 = "SELECT * FROM ussdtransaction WHERE Msisdn = '$msisdn' AND SessionId = '$sessionID'";

        $status = $this->checkIfSessionAlreadyLogged($queryStr1);
        
        if($status == "1"){
            
            $queryStr = "INSERT INTO  ussdtransaction (Msisdn,SessionId) VALUES ('$msisdn','$sessionID')";
            $result = $this->Insertion_UpdateQuerysMainSession($queryStr);
           
            if($result == "0"){
                
                $resultFn = "0";
            }else{
                
                $resultFn = "1";
            }
            
            
        } else {
            
      
          $resultFn = "0";   
        }
        }catch(Exception $ex){
        	
           // echo $ex;
            }
 
             return $resultFn;
    }


function sendMessage($phoneNumber,$message){ 
$msg=str_replace("<br/>","\n",$message);
$resp = "";
try{
$textmessage = urlencode($msg);	
$url = 'http://simplysms.com/getapi.php';
$urlfinal = $url.'?'.'email'.'='.'andxkagwa@gmail.com'.'&'.'password'.'='.'pypG6d2'.'&'.'sender'.'='.'8777'.'&'.'message'.'='.$textmessage.'&'.'recipients'.'='.$phoneNumber;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $urlfinal);
curl_setopt_array($ch,array(
CURLOPT_RETURNTRANSFER =>1,   
//CURLOPT_URL =>$urlfinal,
CURLOPT_USERAGENT =>'Codular Sample cURL Request'));

$resp = curl_exec($ch);

curl_close($ch);
	
}catch(Exception $e){}
return $resp;
//echo  $phoneNumber;
}

    
    public function UpdateUssdTran( $msisdn, $sessionID,$Level,$levelVal){
    
    
    try{
       
        $queryStr = "UPDATE  ussdtransaction SET $Level = '$levelVal' WHERE Msisdn = $msisdn and SessionId = $sessionID";
        
        $result = $this->Insertion_UpdateQuerys($queryStr);
       // echo $result;
      
        }catch(Exception $ex){
        	        
            }
 
    }
    
      public function UpdateUssdTranRegionIds( $msisdn, $sessionID,$districtid,$regionid,$subregionid){
    
    
    try{
       
        $queryStr = "UPDATE  ussdtransaction SET districtid = '$districtid', regionid = '$regionid' , subregionid = '$subregionid' WHERE Msisdn = $msisdn and SessionId = $sessionID";
        
        $result = $this->Insertion_UpdateQuerys($queryStr);
        //echo $result;
      
        }catch(Exception $ex){
        	        
            }
 
    }
	
public function SelectAdvisory($msisdn,$sessionID){
		  try{
       
        $queryStr = "Select * from  ussdtransaction  WHERE Msisdn = $msisdn and SessionId = $sessionID";
        
        $result = $this->SelectQuerys($queryStr);
		
      
        }catch(Exception $ex){
        	        
            }
	}
   
public function getAdvisoryAndLogMessage($queryString,$conn,$PhoneNumber){
       
       try{
           
           $query = $conn->query($queryString);
		if($query->num_rows > 0){
			while($row = $query->fetch_assoc()){
                            if($_SESSION['language'] == "english"){
				$advisory = $row["description"];
                            }else if ($_SESSION['language'] == "luganda") {
                        $advisory = $row["descriptionLuganda"];
                    }
				
			$number = $PhoneNumber; 
            $text = $advisory; 
			$message=str_replace("<br/>","\n",$text);
$sms_api_result = $this->sendMessage($number, $message);


//$this->ussdresponsesender->endResponse();

//send end transaction params
                        }
                }else{
                   
//                    $sms_api_result = $this->smsApi->sendMessage($number, "No Advisory Found");
                    if($_SESSION['language'] == "english"){
                   $action = "end";
                   $strToDisp = "No Advisory Found.";
                   $this->smsApi->ussdResponseSender(trim($strToDisp),$action);
                   
                    }else if($_SESSION['language'] == "luganda"){
                   $action = "end";
                   $strToDisp = "Tetusobodde kufuna kyosabye akasera kano, gezako eddako.";
                   $this->smsApi->ussdResponseSender(trim($strToDisp),$action);
                     
                    }else{
                      
                       $action = "end";
                   $strToDisp = "No Advisory Found.";
                   $this->smsApi->ussdResponseSender(trim($strToDisp),$action);
                        
                    }
                }
           
           
       } catch (Exception $ex){}
       
   }
   
    public function Insertion_UpdateQuerys($sql){
    
    try{
    $conn = $this->connectionStr->ConnectionFc();
        
        
         if ($conn->query($sql) === TRUE) {
  // $ret = "ok";
} else {
    
    
      $action = "end";
                   $strToDisp = "APPLICATION CONNECTION ERROR";
                   $this->smsApi->ussdResponseSender(trim($strToDisp),$action);
   
}
      
//$conn->close();
        
        }catch(Exception $ex){}
    
    
    }
    
   public function Insertion_UpdateQuerysMainSession($sql){
    $status = "";
    try{
    $conn = $this->connectionStr->ConnectionFc();
        
        if($conn == ""){
         
            $status = "1" ;
            
        }else{
          
             if ($conn->query($sql) === TRUE) {
  // 
             $status = "0" ;
} else {
    
     $status = "1" ;
    
}
        }
        
      
//$conn->close();
        
        }catch(Exception $ex){}
    
return $status;
    }
    
     public function checkIfSessionAlreadyLogged($sql){
    $status = "";
    try{
    $conn = $this->connectionStr->ConnectionFc();
        
        
         $query = $conn->query($sql);
            
            if($query->num_rows > 0){
               
                $status = "0";
            } else{
                
                $status = "1";
            }

        
        }catch(Exception $ex){}
    
       return $status;
    
    }

public function selectforecastQueryStrings($strType,$SessionId, $PhoneNumber){
    $queryStr = "";
    switch ($strType){
        
        case    "Seasonal":
            $queryStr = " SELECT seasonal_forecast.season as season,seasonal_forecast.sea_id, seasonal_forecast.description as description,seasonal_forecast.descriptionLuganda as descriptionLuganda, seasonal_forecast.impact as impact, "
." ussdtransaction.Msisdn as telephone, ussdtransaction.regionid as regionid, ussdtransaction.subregionid as subRegion, ussdregions.name as regionname, "
." ussdsubregions.subregionname as subregionname FROM seasonal_forecast LEFT OUTER JOIN ussdtransaction on seasonal_forecast.regionid = ussdtransaction.regionid AND seasonal_forecast.subregionid = ussdtransaction.subregionid "
." LEFT OUTER JOIN ussdregions on ussdtransaction.regionid = ussdregions.regionid "
." LEFT JOIN ussdsubregions ON ussdsubregions.subregionid = ussdtransaction.subregionid" 
." WHERE ussdtransaction.SessionId = '$SessionId' AND "
." ussdtransaction.Msisdn = '$PhoneNumber' "
." group by seasonal_forecast.season, seasonal_forecast.description, "
."seasonal_forecast.impact,ussdtransaction.Msisdn,ussdtransaction.regionid, "
."ussdtransaction.subregionid,ussdregions.name,ussdsubregions.subregionname,seasonal_forecast.sea_id "

." order BY seasonal_forecast.sea_id DESC  LIMIT 1" ;
            break;
        case    "Dekadal":
            $queryStr = " SELECT decadal.advisory as description,decadal.advisoryLuganda as descriptionLuganda, decadal.date_from AS datefrom, decadal.date_to AS dateto, decadal.issuetime as issuedate, "
." ussdtransaction.Msisdn as telephone,decadal.decadal_id, ussdtransaction.regionid as regionid, ussdtransaction.subregionid as subRegion, ussdregions.name as regionname, "
." ussdsubregions.subregionname as subregionname "

." FROM "

." decadal "
." LEFT OUTER JOIN "
." ussdtransaction "

." on decadal.regionid = ussdtransaction.regionid AND decadal.subregionid = ussdtransaction.subregionid "
." LEFT OUTER JOIN "
." ussdregions on ussdtransaction.regionid = ussdregions.regionid "
." LEFT OUTER JOIN "

." ussdsubregions "
." ON ussdsubregions.subregionid = ussdtransaction.subregionid "

." WHERE ussdtransaction.SessionId = '$SessionId' AND ussdtransaction.Msisdn = '$PhoneNumber' "

." group by " 
." decadal.decadal_id,decadal.advisory,decadal.decadal_id, decadal.date_from,decadal.date_to, decadal.issuetime "
." ,ussdtransaction.Msisdn,ussdtransaction.regionid,ussdtransaction.subregionid,ussdregions.name,ussdsubregions.subregionname "

." ORDER BY decadal.decadal_id DESC  LIMIT 1";
            break;
        case    "Daily":
            
            $queryStr = " SELECT daily_forecast.weather as description,daily_forecast.weatherLuganda as descriptionLuganda,daily_forecast.id, daily_forecast.advisory, daily_forecast.date, daily_forecast.time, "
                ." ussdtransaction.Msisdn as telephone, ussdtransaction.regionid as regionid, ussdtransaction.subregionid as subRegion, "
                ."ussdregions.name as regionname, ussdsubregions.subregionname as subregionname FROM "

." daily_forecast LEFT OUTER JOIN ussdtransaction on daily_forecast.regionid = ussdtransaction.regionid AND daily_forecast.subregionid = ussdtransaction.subregionid "
." LEFT OUTER JOIN ussdregions on ussdtransaction.regionid = ussdregions.regionid "
." LEFT OUTER JOIN ussdsubregions ON ussdsubregions.subregionid = ussdtransaction.subregionid "

." WHERE ussdtransaction.SessionId = '$SessionId' AND ussdtransaction.Msisdn = '$PhoneNumber' "
."group by daily_forecast.id,daily_forecast.weather, daily_forecast.advisory, daily_forecast.date, daily_forecast.time "
." ,ussdtransaction.Msisdn,ussdtransaction.regionid,ussdtransaction.subregionid,ussdregions.name,ussdsubregions.subregionname "

."ORDER BY  daily_forecast.id  DESC  LIMIT 1 ";
            
            break;
       }
  
    return $queryStr;
    
}
    public function getDistrictDetails($district){
        
        $regionDetails = "";
        try{
            $conn = $this->connectionStr->ConnectionFc();
            $districtName = strtoupper($district); 
            $sql = "select ussddistricts.districtid as districtid, ussddistricts.districtname "
                    . "as districtname, ussdregions.name AS region, ussdsubregions.subregionname"
                    . " as Subregion, ussdregions.regionid as regionid,ussdsubregions.subregionid as subregionid ,"
                    . "ussddistricts.regionid,ussddistricts.subregionid from ussddistricts "
                    . "INNER JOIN ussdregions ON ussddistricts.regionid = ussdregions.regionid "
                    . "INNER JOIN ussdsubregions ON "
                    . "ussddistricts.subregionid = ussdsubregions.subregionid "
                    . "WHERE ussddistricts.districtname = '$districtName' ";
            $query = $conn->query($sql);
            
            if($query->num_rows > 0){
               
                while($row = $query->fetch_assoc()){
                    
                     if($_SESSION['language'] == "english"){
                     $regionDetails = "District = ".$row["districtname"]." Region = ".$row["region"]." SubRegion: ".$row["Subregion"];
                    }else if($_SESSION['language'] == "luganda"){
                       $regionDetails = "Ddisitulikiti = ".$row["districtname"]." Region: = ".$row["region"]." SubRegion: ".$row["Subregion"];
                     
                    }else{
                         $regionDetails = "District = ".$row["districtname"]." Region =  ".$row["region"]." SubRegion: ".$row["Subregion"];
                   
                   }
                     $districtid = $row["districtid"];
                     $regionid = $row["regionid"];
                     $subregionid = $row["subregionid"];
                     $regionDetails = array($regionDetails,$districtid,$regionid,$subregionid);
               
                    // echo $regionDetails;
                     }
                
            }else{
                
                $regionDetails = "";
            }
            
            
        } catch (Exception $e){}
        return $regionDetails;
    }

    public function loadUssdMenu($menuname){
        
        $menuVal = "";
        $queryProc = "";
        try{
            
       $conn = $this->connectionStr->ConnectionFc();
       
       if($_SESSION['language']== "english"){
           
            $queryProc = "SELECT * FROM ussdmenu WHERE menuname = '$menuname'";
       }else if($_SESSION['language']== "luganda"){
        
            $queryProc = "SELECT * FROM ussdmenuluganda WHERE menuname = '$menuname'";
       }else if($_SESSION['language']== ""){
           
           $queryProc = "SELECT * FROM ussdmenulanguage";
       }
      
       $query = $conn->query($queryProc);
     
       if($query->num_rows > 0){
           
           while($row = $query->fetch_assoc()){
               
               $menuVal = $row["menudescription"]; 
               
           }
       }
            
        } catch (Exception $e){}
      
return $menuVal;
    }

public function SelectQuerys($sql){
    
    try{
   
        $conn = $this->connectionStr->ConnectionFc();
     
     $query = $conn->query($sql);
      
   if($query->num_rows > 0)
  {
	  while($row = $query->fetch_assoc()){
		$mainCategory = $row["Level0"];  
		$subCategory  = $row["Level1"];
		$Location = $row["Location"];
		$PhoneNumber = $row["Msisdn"];
                $SessionId = $row["SessionId"];
		$Advisory = "The".$mainCategory.", Subcategory".$subCategory."for ".$Location." is Test Advisory";
		
  switch ($mainCategory){
  case  "weather-forecast":
      $sqlStr = "";
      switch ($subCategory){
      
      case "Seasonal":
          $strType = "Seasonal";
          $sqlStr = $this->selectforecastQueryStrings($strType,$SessionId,$PhoneNumber);
          break;
      case "Dekadal":
          $strType = "Dekadal";
           $sqlStr = $this->selectforecastQueryStrings($strType,$SessionId,$PhoneNumber);
          break;
      case  "Daily":
          $strType = "Daily";
           $sqlStr = $this->selectforecastQueryStrings($strType,$SessionId,$PhoneNumber);
          break;
      
      }
      
                    // sql script for 
                    //seasonal forecast
                    
		
  $this->getAdvisoryAndLogMessage($sqlStr,$conn,$PhoneNumber);
       
  break;
                
   case "agricultural-advisory":
       
       
   $queryStr = "SELECT advisory.message as description,advisory.messageLuganda as descriptionLuganda, advisory.record_id, advisory.advice, advice.id_advice, advice.advice_name, "
           ." ussdtransaction.Msisdn as telephone, ussdtransaction.regionid as regionid, ussdtransaction.subregionid as subRegion, "
           ." ussdregions.name as regionname, "
." ussdsubregions.subregionname as subregionname FROM advisory LEFT OUTER JOIN ussdtransaction on advisory.regionid = ussdtransaction.regionid "
." AND advisory.subregionid = ussdtransaction.subregionid LEFT OUTER JOIN ussdregions on ussdtransaction.regionid = ussdregions.regionid "
." LEFT OUTER JOIN advice ON ussdtransaction.Level1 = advice.id_advice "
." LEFT OUTER JOIN ussdsubregions ON ussdsubregions.subregionid = ussdtransaction.subregionid WHERE " 
." ussdtransaction.SessionId = '$SessionId' AND ussdtransaction.Msisdn = '$PhoneNumber' "
."  AND advisory.advice = '$subCategory' group by advisory.message,advisory.advice, advice.id_advice, advice.advice_name, ussdtransaction.Msisdn , "
." ussdtransaction.regionid ,advisory.record_id , ussdtransaction.subregionid, ussdregions.name , ussdsubregions.subregionname "

." order BY advisory.record_id DESC LIMIT 1";
   $this->getAdvisoryAndLogMessage($queryStr,$conn,$PhoneNumber);
                    
   break;
                
 case "food-advisory":
                    $queryStr = "SELECT advisory.message as description,advisory.messageLuganda as descriptionLuganda, advisory.advice, advice.id_advice, advice.advice_name, "
           ." ussdtransaction.Msisdn as telephone, advisory.record_id,ussdtransaction.regionid as regionid, ussdtransaction.subregionid as subRegion, "
           ."ussdregions.name as regionname, "
."ussdsubregions.subregionname as subregionname FROM advisory INNER JOIN ussdtransaction on advisory.regionid = ussdtransaction.regionid "
." AND advisory.subregionid = ussdtransaction.subregionid INNER JOIN ussdregions on ussdtransaction.regionid = ussdregions.regionid "
." INNER JOIN advice ON ussdtransaction.Level1 = advice.id_advice "
." INNER JOIN ussdsubregions ON ussdsubregions.subregionid = ussdtransaction.subregionid WHERE ussdtransaction.SessionId = '$SessionId' "
." AND ussdtransaction.Msisdn = '$PhoneNumber' AND advisory.advice = '$subCategory'  group by advisory.message,advisory.advice, advice.id_advice, advice.advice_name, ussdtransaction.Msisdn , "
."ussdtransaction.regionid , ussdtransaction.subregionid,advisory.record_id, ussdregions.name , ussdsubregions.subregionname "

." order BY advisory.record_id DESC LIMIT 1";
                    $this->getAdvisoryAndLogMessage($queryStr,$conn,$PhoneNumber);
                break;
            
               
		
	  }
          }
    
  }else{
	  
	 // echo "No Information found for advisory. Please try again later.";
  }

$conn->close();
        
        }catch(Exception $ex){}
    
    
    }

}

?>
