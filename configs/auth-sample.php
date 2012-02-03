<?php
$hybridAuthConfigs = array(
    "base_url" => "", 

    "providers" => array ( 
        // openid providers
        "OpenID" => array (
            "enabled" => true
        ),

        "Yahoo" => array ( 
            "enabled" => true 
        ),

        "AOL"  => array ( 
            "enabled" => true 
        ),

        "Google" => array ( 
            "enabled" => true,
            "keys"    => array ( "id" => "", "secret" => "" ),
            "scope"   => ""
        ),

        "Facebook" => array ( 
            "enabled" => true,
            "keys"    => array ( "id" => "", "secret" => "" ),
            "scope"   => ""
        ),

        "Twitter" => array ( 
            "enabled" => true,
            "keys"    => array ( "key" => "", "secret" => "" ) 
        ),

        // windows live
        "Live" => array ( 
            "enabled" => true,
            "keys"    => array ( "id" => "", "secret" => "" ) 
        ),

        "MySpace" => array ( 
            "enabled" => true,
            "keys"    => array ( "key" => "", "secret" => "" ) 
        ),

        "LinkedIn" => array ( 
            "enabled" => true,
            "keys"    => array ( "key" => "", "secret" => "" ) 
        ),

        "Foursquare" => array (
            "enabled" => true,
            "keys"    => array ( "id" => "", "secret" => "" ) 
        ),
    ),

    // if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
    "debug_mode" => true,

    "debug_file" => "/home/ombr/debug.txt",
);
