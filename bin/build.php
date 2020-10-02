#!/usr/bin/env php
<?php

$target		= '/usr/local/bin/mkvhost';
$mkpharBin	= 'php -dphar.readonly=0 /usr/local/bin/mkphar';

posix_getuid() === 0 || die( "Run it as root user.\n");

exec( sprintf( "%s %s %s.phar main.php 2>&1 &", $mkpharBin, __DIR__/src, $target ) );
rename( $target.'.phar', $target );
chmod( $target, 0777 );
