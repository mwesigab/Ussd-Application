<?php
ob_start();
include_once 'MoUssdReceiver.php';
include_once 'ussdlog.php';
include_once 'weatherParams.php';
include_once 'DBQueryFunctions.php';
include_once 'UssdLogic.php';
include_once 'smsApi.php';
ini_set('error_log', 'ussd-app-error.log');


$receiver = new MoUssdReceiver(); // Create the Receiver object
$weatherparams = new weatherParams();
$dbFunctions = new DBQueryFunctions();
$logic = new UssdLogic();
$date = new DateTime();
$smsApiFunctions = new smsApi();
 
$receiverSessionId = $receiver->getSessionId();//.$date->getTimestamp();
session_id($receiverSessionId); //Use received session id to create a unique session
session_start();


$message = $receiver->getInput(); // get the message content
$sessionId = $receiver->getSessionId(); // get the session ID;
$msisdn = $receiver->getMSISDN(); // get the phone number
//$serviceCode = $receiver->getMSC(); // get the service code
 $menuName = null;
 $_SESSION['global-Table'] = "UssdTransaction";

//logFile("[ content=$message, sessionId=$sessionId, phonenumber=$msisdn, servicecode=$serviceCode]");

//logic here
if($receiver->getInput() !=null){

		
	if (!(isset($_SESSION['menu-Opt']))) { //Send the main menu

   
            $_SESSION['menu-Opt'] = "language";
            
            //$_SESSION['menu-Opt'] = "main";
 
 	}
 }

 //$menuName = "main";
if ( $receiver->getInput() != "") {
    
	 $menuName = null;
	 
    switch ($_SESSION['menu-Opt']) {
		
        case    "language":
            $_SESSION['menu-Opt'] = $logic->ProcessLanguage($receiver->getInput(), $sessionId, $msisdn);
            break;
	   case "main":
        $_SESSION['menu-Opt'] =  $logic->ProcessMainMenu($receiver->getInput(),$sessionId,$msisdn);
		
            break; 
         
        case "agriculture-and-food-security":
 
         $_SESSION['menu-Opt'] = $logic->ProcessAgriculAdvisory($receiver->getInput());
            break;
            
        case "invaliddistrict":
          $_SESSION['menu-Opt'] =   $logic->invaliddistrict($receiver->getInput());  
               break;
        case "Submission-opt":

         $_SESSION['menu-Opt'] = $logic->SubmissionOpt($receiver->getInput());
            break;            
            
        case "disaster-advisory":

            
         $_SESSION['menu-Opt'] = $logic->FoodAdvisory($receiver->getInput());
            break;
        case "weather-forecast":
              
          $_SESSION['menu-Opt'] = $logic->WeatherForecast($receiver->getInput());
            break;
        case "give-feedback":

           $_SESSION['menu-Opt'] =  $logic->Feedback($receiver->getInput());
            break;
        case "advise-impact":

           
          $_SESSION['menu-Opt'] =  $logic->AdviseImpact($receiver->getInput());
            break;

        case "indigenous-contribution":
 
          $_SESSION['menu-Opt'] =  $logic->IndiginousContribution($receiver->getInput());
            break;
            
        case "invalidinput":
 
          $_SESSION['menu-Opt'] =  $logic->invalidinput($receiver->getInput());
            break;
            
        case "Indiginous-Regions" || "regions":

       $_SESSION['menu-Opt'] =   $logic->Regions($receiver->getInput());    
            break;  
       
       }

}else{
$action = "end";
$strToDisp = "Error Occured";
$this->smsApi->ussdResponseSender($strToDisp,$action);
//session_destroy();

}

?>
