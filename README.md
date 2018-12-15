Herbie Website (Kick)-Starter
=============================

Dein neues Website-Projekt startest du mit Hilfe von Composer. 

    $ composer create-project getherbie/start-website myproject
    
Composer installiert eine einfache Herbie-Website mit allen Abhängigkeiten in das Verzeichnis `myproject`. 

Die obigen Schritte kannst du natürlich auch einzeln ausführen:

	$ git clone https://github.com/getherbie/start-website.git myproject
    $ cd myproject
    $ composer update
    
Nun wechselst du in's Webverzeichnis und startest den internen Webserver von PHP.

    $ cd myproject/web
    $ php -S localhost:8888

Jetzt musst du nur noch die Website im Browser unter <http://localhost:8888> aufrufen.

Fertig!

Weitere Informationen zu Herbie findest du unter [Herbie](https://www.getherbie.org)

## Docker verwenden
Die Docker-Konfiguration findest du in folgenden Dateien:
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

Du solltest zunächst in der Datei `docker/nginx/app.conf` den Servernamen anpassen (`server_name your-domain.tld;` -> zB. `server_name mydomain.org`).

Anschließend einfach mit `docker-compose up -d` den Docker-Container starten und zB. http://mydomain.org (oder die von dir konfigurierte Domain) aufrufen.
