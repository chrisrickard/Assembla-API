<?php

require_once( 'constaints.php' );
require_once( 'classes/ErrorHandler.php' );
require_once( 'classes/AssemblaAPI_Model.php' );
require_once( 'classes/AssemblaAPI_View.php' );


//header ("Content-Type:text/xml");  
$foo = new AssemblaAPI_Model( 'configs/model.xml' );
//var_dump($foo->getConfigUri( 'defaults/url' ) );

var_dump($foo->getConfigUri('/config/defaults/url') );
var_dump($foo->getConfigUri('/config/services') );
var_dump($foo->getConfigUri('/config') );
var_dump($foo->getConfigUri('/config/services/my_spaces_list/headers') );
var_dump($foo->getConfigUri('/config/services/my_spaces_list/headers/header') );
var_dump($foo->getConfigUri('//header'));


/*
$xml_doc = <<<XML
<?xml version='1.0'?>
<!-- without namespace: -->
<!-- <document> -->
<!-- with default namespace: -->
<document>
 <title>Forty What?</title>
 <from>Joe</from>
 <to>Jane</to>
 <body>
  I know that's the answer -- but what's the question?
 </body>
 <test>
	<foo>bar</foo>
	<foo>baz</foo>
 </test>
</document>
XML;

$xml = simplexml_load_string($xml_doc);

var_dump($xml);
*/
?>