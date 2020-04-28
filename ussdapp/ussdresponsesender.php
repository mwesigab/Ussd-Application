<?php
include_once 'smsApi.php';

?>
<?php
class ussdresponsesender{
 public function __construct(){
     
     $this->smsApi = new smsApi;
 }
    function endResponse(){
          if($_SESSION['language'] == "english"){
              
              $action = "end";
                   $strToDisp = "You will receive a message shortly";
                   $this->smsApi->ussdResponseSender(trim($strToDisp),$action);
         
        }else if($_SESSION['language'] == "luganda"){
          $action = "end";
                   $strToDisp = "Tujja kukusindikira SMS mukaseera katini nyo";
                   $this->smsApi->ussdResponseSender(trim($strToDisp),$action);
            
        }
//session_destroy();    
        }
    
}
?>
