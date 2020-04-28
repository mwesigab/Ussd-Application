#!/usr/bin/php
 
<?php
include_once ('SelectAdvisory.php');

$log = '/var/www/html/smsApp/newfile.txt'; 

// Create an object of the SelectAdvisory class
$selectObj = new SelectAdvisory();

    //fork the process to work in a daemonized environment
    file_put_contents($log, "Status: starting up.n", FILE_APPEND);
    $pid = pcntl_fork();
    if($pid == -1){
        file_put_contents($log, "Error: could not daemonize process.n", FILE_APPEND);
        return 1; //error
    }
    else if($pid){
        return 0; //success
    }
    else{
        //the main process
        $count=0;
        while(true){
            $selectObj->SelectAdvisory($count); 
//            file_put_contents($log, 'Running...', FILE_APPEND);
            sleep(5);
            if($count >= 5){
                unset($count);
                $count=0;
            }else{
                $count++;
            }
        }//end while
    }//end if/end while
 
?>
