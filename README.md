# Installation

* Installez les dépendances : ```composer update```
* Modifiez vos identifiants MySQL dans le fichier ```.env``` (ligne 26).
* Créer la base de données : ```symfony console doctrine:databse:create```
* Appliquer les migrations : ```symfony console doctrine:migrations:migrate```
* Charger les fixtures : ```symfony console doctrine:fixtures:load```
* Démarrer le serveur Symfony : ```symfony server:start -d```
