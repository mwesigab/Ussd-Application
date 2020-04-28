<?php


class MoUssdReceiver{

    //private $sourceAddress; // Define required parameters to receive response
//    private $message;
//    private $requestId;
//    private $applicationId;
//    private $encoding;
//    private $version;
//    private $sessionId;
//    private $ussdOperation;
//    private $vlrAddress;

    private $MSISDN;
    //private $password;
    private $userid;
    private $INPUT;
   // private $MSC;
    private $SESSIONID;
    private $SHORTCODE;
    private $TYPE;
 


    /*
        decode the json data and get them to an array
        Get data from Json objects
        check the validity of the response
    **/

    public function __construct(){
        $this->MSISDN = $_GET['msisdn'];
       // $this->password = $_GET['password'];
        $this->SHORTCODE = $_GET['ussdServiceCode'];
        $this->INPUT = $_GET['ussdRequestString'];
       // $this->MSC = $_GET['MSC'];
        $this->SESSIONID =$_GET['transactionId'];
        $this->TYPE = "0";//$_GET['TYPE'];

//        $array = json_decode(file_get_contents('php://input'), true);
//        $this->message = $array['message'];
//        $this->sessionId = $array['sessionId'];
//        $this->$serviceCode = $array['serviceCode'];
//        $this->$msisdn = $array['msisdn'];


       // if (!(isset($this->MSISDN) && isset($this->SESSIONID) && (($this->SHORTCODE) =="*289*22#") && (($this->TYPE) =="0" || ($this->TYPE) =="1" ) )) {
//		print_r("Unauthorized Request");
//		header('Content-type:text/plain');
       // 	print_r("Un-Authorized Request");
       //         return;
          //  throw new Exception("Unauthorized Request");
     // } else {
            // Success received response

      //      $responses = "SUCCESS";
    //       $_POST['STATUSCODE'] = "200";
  //        $_POST['STATUSDESCRIPTION'] = $responses;

//print_r("Success");
            // array("statusCode" => "0", "statusDetail" => "Success");
          //  header("Content-type: application/text");
          //  echo json_encode($responses);
  //   }
   }

    /*
        Define getters to return receive data
    **/
    
    public function getMSISDN(){
        return $this->MSISDN;
    }
    public function getSessionId(){

        return $this->SESSIONID;
    }
    public function  getShortCode(){


        return $this->SHORTCODE;
    }

    public function getInput(){
        return $this->INPUT;
    }
    public function getType(){

        return $this->TYPE;
    }

    //public function getPassword(){
     //   return $this->password;
    //}

  // public function getUserid(){
   //     return $this->userid;
  //  }
   // public function getMSC(){
   //     return $this->MSC;
   // }




}

?>
