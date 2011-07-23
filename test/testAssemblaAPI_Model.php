<?php

require_once( '../constants.php' );
require_once( '../classes/AssemblaAPI_Model.php' );


class AssemblaAPI_ModelTest extends PHPUnit_Framework_TestCase {


      protected $_obj;
      protected $_config;

      public function setUp(){
	     $this->_obj = new AssemblaAPI_Model();
	     $this->_config = $this->_obj->getConfig();
      }

      /* make sure credentials exist */
      public function testCredentials(){

	     $this->assertInstanceOf( 'SimpleXMLElement', $this->_obj->getConfigUri('credentials') );
	     $this->assertTrue( $this->_obj->getConfigUri('credentials/username') !== "" );
	     $this->assertTrue( $this->_obj->getConfigUri('credentials/password') !== "" );

      }
      /* make sure defaults exist*/
      public function testDefaults(){
      	     
     	     $this->assertInstanceOf( 'SimpleXMLElement', $this->_obj->getConfigUri('defaults') );
     	     $this->assertTrue( $this->_obj->getConfigUri('defaults/url') !== "" );
      
      }
      
      public function testServices(){
      	     $this->assertInstanceOf( 'SimpleXMLElement', $this->_obj->getConfigUri('services') );
      }
      
      private function _checkHeader( $str ){
        $valid_headers = array( "Accept",
		       	 	"Accept-Charset",
				"Accept-Encoding",
				"Accept-Language",
				"Authorization",
				"Cache-Control",
				"Connection",
				"Cookie",
				"Content-Length",
				"Content-MD5",
				"Content-Type",
				"Date",
				"Expect",
				"From",
				"Host",
				"If-Match",
				"If-Modified-Since",
				"If-None-Match",
				"If-Range",
				"If-Unmodified-Since",
				"Max-Forwards",
				"Pragma",
				"Proxy-Authorization",
				"Range",
				"Referer",
				"TE",
				"Upgrade",
				"User-Agent",
				"Via",
				"Warning"
			      );


     	preg_match( "/^(.*):/", $str, $matches );
	$this->assertInternalType( 'string', $matches[1] );
	$this->assertTrue( in_array($matches[1], $valid_headers) );

      }

      private function _testServiceConfig( $uri ){

	     $this->assertInstanceOf( 'SimpleXMLElement', $this->_obj->getConfigUri('services/' . $uri . '') );
	     $this->assertTrue( $this->_obj->getConfigUri('services/' . $uri . '/uri') !== "" );
	     $this->assertTrue( $this->_obj->getConfigUri('services/' . $uri . '/type') !== "" );

	     if( $this->_obj->getConfigUri('services/' . $uri . '/headers') !== "" ):
	         $headers = $this->_obj->getConfigUri('services/' . $uri . '/headers');
	         $this->assertInternalType( 'array', $headers );
	     	 foreach( $headers AS $header ):
		 	  $this->assertInternalType( 'string', $header );
			  $this->_checkHeader($header);
		 endforeach;
	     endif;

      }


      public function testLoadMySpacesList(){
      	     $this->_testServiceConfig( "my_spaces_list" );
      }

}

?>