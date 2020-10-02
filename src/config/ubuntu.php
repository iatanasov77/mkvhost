<?php

$config	= array(
	'vhostConfDir'	=> '/etc/apache2/sites-available',
	'apacheLogDir'	=> '/var/log/apache2/',
	'apacheService'	=> 'apache2'
);

return array_merge( require 'default.php', $config );
