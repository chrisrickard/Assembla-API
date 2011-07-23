<?php
require_once( 'AssemblaAPI_Base.php' );

class AssemblaAPI_Model extends AssemblaAPI_Base {

const CONST_GET_STRING = 'GET';
const CONST_POST_STRING = 'POST';

protected $_xml;

public function __call($method, $args){

       if(substr($method, 0, 4) == "load"):
           $key = $this->_underscore(substr($method,4));
	   try {
	       $this->_xml = new SimpleXMLElement($this->_queryService( 'services/' . $key ));
	   } catch (Exception $e){
	       ErrorHandler::Error(ErrorHandler::EXCEPTION, $e->getMessage() );
	   }
       endif;

       return $this;

}


/*
 *  @pre:    none
 *  @post:   nessisary information for queryService() is contained
 *           in $this->_config;
 *  @input:  none
 *  @output: none
 *
 */

public function loadXmlConfig(){
       $_config = simplexml_load_file( PATH . 'configs/model.xml' );
       return $this;
}

/*
 *    @pre:    requires 'credentials/username'
 *     	       requires 'credentials/password'
 *	       requires 'defaults/url'
 *    @post:   none;
 *    @input:  none
 *    @output: returns the API Url not including the service URI
 */
protected function _getAPIUrl(){
	  // http://user:password@www.assembla.com/
	  return "http://" . $this->getConfigUri('credentials/username') .
	         ":"       . $this->getConfigUri('credentials/password') .
		 "@"       . $this->getConfigUri('defaults/url') .
		 "/";
}

/*
 *   @pre:
 *   @post:
 *   @input:
 *   @output:
 */
protected function _setOps( $serviceUri, $varmap, $handle ){
	      
	      curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);

	      $headers = $this->getConfigUri($serviceUri . "/headers");

	      if( $headers instanceof SimpleXMLElement ):
	      	  foreach($headers AS $header):
		  	$headeropts[] = (string)$header[0];
		  endforeach;
	          curl_setopt($handle, CURLOPT_HTTPHEADER, array_values($headeropts));
	      endif;

	      //  *** UNTESTED ***
	      $type = $this->getConfigUri($serviceUri . "/type");
	      if( $type == AssemblaAPI_Model::CONST_POST_STRING && !empty($varmap) ):
	      	  curl_setopt($handle, CURLOPT_POST, 1);
		  curl_setopt($handle, CURLOPT_POSTFIELDS, $varmap);
	      endif;

}


/*
 *   @pre:     $service exists in 'services/'  configuration
 *   @post:    none
 *   @input:   required $service - config uri name of the service being called
 *             optional $varmap  - key/value pairs of of arguments to be passed
 *                                 to the service.
 *   @output:  string (xml) returned by the service.
 */

protected function _queryService( $serviceUri,  $varmap = array() ){


	  //PHP evaluates '' as false
	  if( $this->getConfigUri($serviceUri) ):
	      $url = $this->_getAPIUrl() . $this->getConfigUri($serviceUri . "/uri");

	      try {
	      	  $ch = curl_init( $url );

	      	  $this->_setOps( $serviceUri, $varmap, $ch );

	      	  $out = curl_exec ($ch);

		  if( $out !== false ):
	      	      curl_close ($ch);
		  else:
		     $out = '<?xml version="1.0" encoding="UTF-8"?>';
		     ErrorHandler::Error(ErrorHandler::WARNING, "curl for service URI " . $serviceUri . " returned nothing.");
		  endif;    
	      	  return $out;
	      } catch (Exception $e) {
	      	ErrorHandler::Error( ErrorHandler::EXCEPTION, $e->getMessage() );
	      }
	  else:
	      ErrorHandler::Error( ErrorHandler::CRITICAL, $serviceUri . " is not set!");
	  endif;

}

}

?>