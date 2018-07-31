# mkvhost
PHP CLI Application to automate the creation of apache virtual hosts , add host to /etc/hosts file and restart the apache server

1. Download Last stable packed release ( At this moment is: 0.2.0 )
	```
	# wget https://github.com/iatanasov77/mkvhost/releases/download/v0.2.0/mkvhost.phar
	```
2. Usage
	```
	# php mkvhost.phar -t simple -a 192.168.0.1 -s example.lh -d /var/www/MyProject
	```
	