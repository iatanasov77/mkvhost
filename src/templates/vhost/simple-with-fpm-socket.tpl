<VirtualHost *:80>
    ServerAdmin {__serverAdmin__}
    ServerName {__serverName__}
    ServerAlias www.{__serverName__}
    DocumentRoot {__documentRoot__}
    
    <IfModule mod_env.c>
        SetEnv APP_ENV 'development'
    </IfModule>
    
    CustomLog {__apacheLogDir__}{__serverName__}-access.log combined
    ErrorLog {__apacheLogDir__}{__serverName__}-error.log

    <Directory {__documentRoot__}>
   	   AllowOverride All
       Require all granted
    </Directory>
    
    <Proxy "unix:{__fpmSocket__}|fcgi://php-fpm">
        ProxySet disablereuse=off
    </Proxy>
    <FilesMatch \.php$>
        SetHandler proxy:fcgi://php-fpm
    </FilesMatch>

</VirtualHost>