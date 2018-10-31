#### This is a simple file hosting laravel web application boilerplate.

Features:

* Safe upload of files using nginx x-accel directive
* full-text search using postgresql built-in capabilities   
* Just pure js, no frameworks used

This application uses x-accel redirect for safe and fast downloads.
https://www.nginx.com/resources/wiki/start/topics/examples/x-accel/

Add this to your nginx configuration:

```
    location /uploads {
        internal;
        root /path/to/project/root/;
    }
```

For homestead don't forget to add connection setting for postgresql in .env file:

```

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=rghost
DB_USERNAME=homestead
DB_PASSWORD=secret

```

##### To Do

* create postgresql function to update search column on trigger instead of php function

##### Credits:

* zondicons: http://www.zondicons.com/

* free file type icons: https://github.com/redbooth/free-file-icons
