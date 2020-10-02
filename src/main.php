#!/usr/bin/php
<?php

// Must to be root user
posix_getuid() === 0 || die("You must to be root.\n");

require_once 'detect_linux.php';
require_once 'functions.php';
require_once 'resolve_options.php';

/**
 * Globals
 */
$dirSep		= DIRECTORY_SEPARATOR;
$rootDir	= dirname( __FILE__ );

$config         = loadConfig();
$vhostConfFile	= $config['vhostConfDir'] . '/' . $opt['s'] . '.conf';

// Check if virtual host exixts
if ( file_exists( $vhostConfFile ) && ! array_key_exists( 'f', $opt ) )
{
    die("There is a VirtualHost with such ServerName.\n");
}



/**
 * *********************************
 * START MAIN APPLICATION
 * 
 * *********************************
 */

/**
 * Create a host record
 */
$hosts = file_get_contents('/etc/hosts');
if( stripos( $opt['s'], $hosts ) === FALSE )
{
    file_put_contents( '/etc/hosts', sprintf( "%s\t%s www.%s\n", $opt['a'], $opt['s'], $opt['s'] ), FILE_APPEND );
}

/**
 * Create Virtual Host
 */
$vhostTpl	= loadVhostTpl( $opt['t'] );
$params		= array(
    'serverAdmin'       => $config['serverAdmin'],
    'apacheLogDir'      => $config['apacheLogDir'],
    
    'serverName'        => $opt['s'],
	'documentRoot'	    => $opt['d'],
    
    'fpmSocket'         => $opt['p'],
    'reverseProxyUri'   => $opt['r']
);
$vhost		= renderTemplate( $vhostTpl, $params );

file_put_contents( $vhostConfFile, $vhost);

/**
 * Activate Virtual Host
 */
if( $OS == 'Ubuntu' ) {
    exec( "a2ensite " . $opt['s'] );
}
exec("service {$config['apacheService']} restart"); // Reload Apache
