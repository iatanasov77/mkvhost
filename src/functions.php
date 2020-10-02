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
 * Script Usage
 */
function Usage()
{
	global $argv;

	$usage = "Usage: " . $argv[0] . " -t vhost_template -s your_domain.com -d /path/to/document_root";

	return $usage;
}
