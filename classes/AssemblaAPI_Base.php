<?php

class AssemblaAPI_Base {

protected $_config = "";
protected $_configPath = "configs/model.xml";

/*
 *  @pre:  none
 *  @post: the object is initialized with configuration data
 */

public function __construct(){
       $a = func_get_args();
       $i = func_num_args();
    
       switch( $i ){
       	       case 1:
       	       	    $this->_loadConfig( $a[0] );
       		    $this->_init();
	            break;
	       default:
		    $this->_loadConfig();
		    $this->_init();
	       break;
       }
}


/*
 *  @pre:    none
 *  @post:   none
 *  @input:  takes a string
 *  @output: removes underscore and camel cases the string
 *  @notes:  juked from magento's varien_object
 */
protected function _underscore($name) {
	return strtolower(preg_replace('/(.)([A-Z])/', "$1_$2", $name));
}


/*
 *  @pre:  none
 *  @post: any object initialization nessiary
 */

protected function _init(){
	  //virtual function
}

/*
 *  @pre:    none
 *  @post:   nessisary information for queryService() is contained
 *           in $this->_config;
 *  @input:  none
 *  @output: none
 *
 */

protected function _loadConfig( $file = ""){
       if( $file ):
           if( is_readable( $file ) ):
	       $xml = file_get_contents( PATH . $file );
               $this->_config = new SimpleXMLElement( $xml );
	   else:
	       ErrorHandler::Error(ErrorHandler::CRITICAL, $file . ' is not readable!');
	   endif;
       else:
	$this->_config = simplexml_load_file( PATH . $this->_configPath );
       endif;
       return $this;
}


protected function _returnElement( $element ){
	  if( $element instanceof SimpleXMLElement ):
	      if( trim((string) $element) && trim((string) $element) !== 'Array' ):
	      	      return (string) $element;
	      endif;    
	  endif;

	  return $element;
}

/*
 *  @pre:    none
 *  @post:   none
 *  @input:  required  $path - configuration URI
 *  @output: returns the value of a configuration element contained 
 *           in $this->$_config if it exists,  or returns an empty 
 *           string.
 */



protected function _queryXML( $path, $rootElement ){
       if( !empty($path) ):
       	   if( $rootElement && $rootElement instanceof SimpleXMLElement ):
	       $elements = $rootElement->xpath( $path );

	       if( count($elements) == 1 ):
	           return $this->_returnElement(  current($elements) );
	       else:
	           $returnArr = array();
	           foreach( $elements AS $element ):
		   	if( $element instanceof SimpleXMLElement ):
		   	    $returnArr[] = $this->_returnElement( $element );
			else:
			    $returnArr[] = $element;
			endif;
		   endforeach;
		   return $returnArr;
	       endif;
	   else:
	       ErrorHandler::Error(ErrorHandler::WARNING, '$rootElement cannot be empty!');
	       return false;
	   endif;
       else:
           ErrorHandler::Error(ErrorHandler::WARNING, '$path cannot be empty!');
	   return false;
       endif;
       
}


public function getConfigUri( $path ){
       if( $this->_config instanceof SimpleXMLElement ):
       	   return $this->_queryXML( $path, $this->_config);
       else:
           return '';
       endif;
}

public function getXMLValue( $path ){
       if( $this->_xml instanceof SimpleXMLElement ):
       	   return $this->_queryXML( $path, $this->_xml);
       else:
           return '';
       endif;

}


/*
public function getConfigUri( $path ){
	  // this will will probably be a simple wrapper around
	  // the xpath function once we move away from a static
	  // config 
	  if( !empty($path) ):

	      $path_array = explode( '/', $path );

	      if( get_class($this->_config) == "SimpleXMLElement"):
	          $value = $this->_config;
	      	  foreach( $path_array AS $element ):
	      	       if( get_class($value) == "SimpleXMLElement" && in_array($element, array_keys($value)) ):
		       	   $value = $value[$element];
		       else:
			    $value = '';
			    break;
		       endif;
	      	  endforeach;
		  return $value;
	      else:
	          ErrorHandler::Error(ErrorHandler::CRITICAL, '$this->_config is not an array!');
		  return false;  
	      endif;
	  else:
	      ErrorHandler::Error(ErrorHandler::CRITICAL, '$path cannot be empty!');
	      return $false;
	  endif;
}
*/

public function asXml( ) {
       return $this->_xml;
}

public function getConfig( $file = "" ){
       if(empty($this->_config)):
	$this->_loadConfig( $file );
       endif;

       return $this->_config;
}


}

?>