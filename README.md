# dujitang
没事打开看看， 毕竟人生苦短都没苦笑过那学有什么意思！https://x.niuyanben.com


```nginx
server {
	listen 80;

	root /var/www/html/dujitang/;

	index index.html index.php;

	server_name dujitang.loc;

    location / {
       try_files $uri $uri/ /index.php;
    }


	# pass PHP scripts to FastCGI server
	#
	location ~ \.php$ {
		include snippets/fastcgi-php.conf;
		fastcgi_pass unix:/run/php/php7.2-fpm.sock;
	}
}
```