#!/usr/bin/php
<?php

require_once 'functions.php';

// Get Option Switches
$opt = getopt('a:s:d:t:f');

/*
 * Globals
 */
$dirSep		= DIRECTORY_SEPARATOR;
$rootDir	= dirname( __FILE__ );
$OS 		= shell_exec('lsb_release -si');
$config		= loadConfig();

// Must to be root user
posix_getuid() === 0 || die("You must to be root.\n");

// Check parameters
if ( ! isset( $opt['t'] ) || ! isset( $opt['s'] ) || ! isset( $opt['d'] ) )
{
	die( Usage()."\n" );
}
if ( ! isset( $opt['a'] ) )
{
    $opt['a']   = '127.0.0.1';
}

$vhostConfFile	= $config['vhostConfDir'] . '/' . $opt['s'] . '.conf';

// Check if virtual host exixts
if ( file_exists( $vhostConfFile ) && ! array_key_exists( 'f', $opt ) )
{
    die("There is a VirtualHost with such ServerName.\n");
}

// Create a host record
$hosts = file_get_contents('/etc/hosts');
if( stripos( $opt['s'], $hosts ) === FALSE )
{
    file_put_contents( sprintf( '/etc/hosts', "%s\t%s www.%s\n", $opt['a'], $opt['s'], $opt['s'] ), FILE_APPEND );
}

// Create Virtual Host
$vhostTpl	= loadVhostTpl( $opt['t'] );
$params		= array(
	'serverAdmin'	=> $config['serverAdmin'],
	'serverName'	=> $opt['s'],
	'documentRoot'	=> $opt['d'],
	'apacheLogDir'	=> $config['apacheLogDir']
);
$vhost		= renderTemplate( $vhostTpl, $params );

file_put_contents( $vhostConfFile, $vhost);
if($OS == 'Ubuntu') {
	exec("a2ensite {$opt['s']}");
}

// Reload Apache
exec("service {$config['apacheService']} restart");
