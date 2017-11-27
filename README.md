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

Weitere Informationen zu Herbie findest du unter [Herbie](http://www.getherbie.org)
