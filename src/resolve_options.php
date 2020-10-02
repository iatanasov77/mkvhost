<?php

// Get Option Switches
$opt = getopt('a:s:d:t:f:r:p:');
/**
 * Options description
 * --------------------
 * a: Address ( Default: 127.0.0.1)
 * s: Host name ( Mandatory )
 * d: Document Root ( Mandatory )
 * t: Template
 * f: Force override virtual host
 * p: PhpFpm Socket
 * r: Reverse Proxy
 */
//var_dump($opt['r']); die;

/**
 * Check mandatory options
 */
if ( ! isset( $opt['s'] ) || ! isset( $opt['d'] ) )
{
    die( Usage()."\n" );
}

/**
 * Set Defaults
 */
if ( ! isset( $opt['a'] ) )
{
    $opt['a']   = '127.0.0.1';
}

if ( ! isset( $opt['t'] ) )
{
    switch ( true ) {
        case isset( $opt['r'] ):
            $opt['t']   = 'simple-with-reverse-proxy';
            break;
        case isset( $opt['p'] ):
            $opt['t']   = 'simple-with-fpm-socket';
            break;
        default:
            $opt['t']   = 'simple';
    }
}
//var_dump($opt['t']); die;
