<?php

function getOSInformation()
{
    if ( false == function_exists( "shell_exec" ) || false == is_readable( "/etc/os-release" ) ) {
        return null;
    }
    
    $os         = shell_exec( 'cat /etc/os-release' );
    $listIds    = preg_match_all( '/.*=/', $os, $matchListIds );
    $listIds    = $matchListIds[0];
    
    $listVal    = preg_match_all( '/=.*/', $os, $matchListVal );
    $listVal    = $matchListVal[0];
    
    array_walk($listIds, function( &$v, $k ){
        $v = strtolower( str_replace( '=', '', $v ) );
    });
        
    array_walk( $listVal, function( &$v, $k ) {
        $v = preg_replace( '/=|"/', '', $v );
    });
            
    return array_combine( $listIds, $listVal );
}

$osInfo = getOSInformation();
$OS     = $osInfo['name'] == 'CentOS Linux' ? 'CentOS' : $osInfo['name'];

