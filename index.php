<?php

require_once( 'constants.php' );
require_once( 'classes/ErrorHandler.php' );
require_once( 'classes/AssemblaAPI_Model.php' );
require_once( 'classes/AssemblaAPI_View.php' );


//header ("Content-Type:text/xml");  
$foo = new AssemblaAPI_Model( 'configs/model.xml' );

//var_dump($foo->getConfigUri( 'defaults/url' ) );
//var_dump($foo->getConfigUri('/config/defaults/url') );
//var_dump($foo->getConfigUri('/config/services') );
//var_dump($foo->getConfigUri('/config') );
//var_dump($foo->getConfigUri('/config/services/my_spaces_list/headers') );
//var_dump($foo->getConfigUri('/config/services/my_spaces_list/headers/header') );
//var_dump($foo->getConfigUri('//header'));

var_dump($foo->loadMySpacesList());


?>