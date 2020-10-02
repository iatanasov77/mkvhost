<?php

function renderTemplate( $tpl, $params )
{
	$tplKeys	= array_map(
		function( $key ) { return sprintf( '{__%s__}', $key ); },
		array_keys( $params )
	);
	
	return str_replace( $tplKeys, array_values( $params ), $tpl );
}

/**
 *
 * @param	string $vhostTpl
 * @return	string
 */
function loadVhostTpl( $vhostTpl )
{
	global $dirSep, $OS, $rootDir;

	return file_get_contents( $rootDir . $dirSep . 'templates' . $dirSep . 'vhost' . $dirSep . $vhostTpl . '.tpl' );
}

/**
 * @brief	Get virtual host conf file by operating system
 *
 * @return	void
 */
function loadConfig()
{
	global $dirSep, $OS, $rootDir;

	if ( stripos( $OS, 'SUSE' ) !== false )
	{
		return require( $rootDir . $dirSep . 'config' . $dirSep . 'suse.php' );
	}
	elseif ( stripos( $OS, 'Ubuntu' ) !== false )
	{
		return require( $rootDir . $dirSep . 'config' . $dirSep . 'ubuntu.php' );
	}
	elseif ( stripos( $OS, 'CentOS' ) !== false )
	{
		return require( $rootDir . $dirSep . 'config' . $dirSep . 'centos.php' );
	}
	else
	{
		throw new Exception( 'Unsupported operation system.' );
	}
}

/**
 * Print Usage
 */
function Usage()
{
	global $argv;

	$usage = "
============================================================================================================================================ \n
= Usage \n
============================ \n
= \n
= Usage: " . $argv[0] . " -t vhost_template -s your_domain.com -d /path/to/document_root \n
= \n
= Simple Usage: " . $argv[0] . " -s your_domain.com -d /path/to/document_root \n
= \n
= Add Reverse Proxy: " . $argv[0] . " -s your_domain.com -d /path/to/document_root -r http://127.0.0.1:5000/ \n
= \n
= Add PhpFpm Socket(FCGI): " . $argv[0] . " -s your_domain.com -d /path/to/document_root -p /opt/phpbrew/php/php-7.4.1/var/run/php-fpm.sock \n
= \n
============================================================================================================================================ \n
";

	return $usage;
}
