<?php

class ErrorHandler{
       const CRITICAL = 1;
       const EXCEPTION = 2; 
       const WARNING = 3;

       static public function Error( $type, $msg ){
       	      switch($type){
      		  case ErrorHandler::WARNING:
		      echo "<strong>" . $msg . "</strong><br/>";
		      break;
		  case ErrorHandler::CRITICAL:
		  case ErrorHandler::EXCEPTION:
	      	  default:
		      die( $msg );
	      }
       }

}


?>