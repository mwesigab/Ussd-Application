<?php 

class ConfigFile{
    
    private $portNum = null;
    private $hostVal = null;
    
    
    
   public function __construct(){
     $this->$portNum = 8001;
     $this->$hostVal ="192.168.4.555";
       
   }
    public function getPortNum(){
        return $this->portNum;
        
    }
     public function getHostVal(){
        return $this->hostVal;
        
        }
    
    
    }



?>