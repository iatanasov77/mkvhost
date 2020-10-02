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
        Options All Indexes FollowSymlinks
        AllowOverride All
    
        <IfModule !mod_access_compat.c>
                Require all granted
        </IfModule>
        <IfModule mod_access_compat.c>
                Order allow,deny
                Allow from all
        </IfModule>

        DirectoryIndex index.php index.html
    </Directory>

</VirtualHost>