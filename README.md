# Website Kickstarter for Herbie CMS

## Install Herbie CMS using Composer

You can start your new Herbie CMS website by using Composer.

    # for the stable version 1
    $ composer create-project getherbie/start-website myproject

    # for the dev-master version
    $ composer create-project getherbie/start-website:dev-master myproject
    
Composer installs a simple demo website including the needed dependencies into the `myproject` folder. 

Alternatively, you can run the above commands step-by-step:

	$ git clone https://github.com/getherbie/start-website.git myproject
    $ cd myproject
    $ composer install

In your terminal go to the web directory and start the internal PHP webserver.

    $ cd myproject/web
    $ php -S localhost:8888 index.php

Now, open the URL <http://localhost:8888> in your browser. Finished!


## Install Herbie CMS using Docker

You can find the Docker configuration files here:

```
docker-compose.yml
docker
    - nginx
        - app.conf
docker
    - php
        - Dockerfile
        - php.ini
```

First, you should update the server name in the config file `docker/nginx/app.conf` (`server_name your-domain.tld;` -> for example `server_name mydomain.org`).

Then start the Docker container by using `docker-compose up -d` in the root dir of the website.

Now, open the URL <http://0.0.0.0> or <http://mydomain.org> in your browser. Finished!

## More Information

<https://herbie.tebe.ch>
