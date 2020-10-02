<?php

$config	= array(
	'vhostConfDir'	=> '/etc/httpd/conf.d/',
	'apacheLogDir'	=> '/var/log/httpd/'
);

return array_merge( require 'default.php', $config );
