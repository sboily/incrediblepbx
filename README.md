# incredible pbx

This is a demo to create a php dashboard on top of wazo-platform. Created with Ward Mundy for fun.

Installation
------------

Configuration
-------------

Configure the config.inc.php in directory config.

Docker
------

You can use docker

    docker build -t incrediblepbx .
    docker run -p 80:80 -t incrediblepbx

It's possible to import all of this variable

- WAZO_HOST
- WAZO_PORT
- WAZO_BACKEND_USER

```
    docker run -p 80:80 -e WAZO_HOST=192.168.1.124 \
                        -e WAZO_PORT=443 \
                        -e WAZO_BACKEND_USER=wazo_user \
                        -t incrediblepbx
```
