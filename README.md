# incredible pbx

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

- XIVO_HOST
- XIVO_BACKEND_USER

```
    docker run -p 80:80 -e XIVO_HOST=192.168.1.124 \
                        -e XIVO_BACKEND_USER=xivo_admin \
                        -t incrediblepbx
```
