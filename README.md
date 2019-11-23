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


### SQL
```sql
CREATE TABLE `archive` ( 
`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 
`content` TEXT NOT NULL, `author` TEXT, 
`likes` INTEGER NOT NULL, 
`unlikes` INTEGER NOT NULL DEFAULT 0, 
`favorites` INTEGER NOT NULL, 
`creatTime` INTEGER NOT NULL 
)
```
