# Dashboard-MVC

Application PHP MVC de gestion, 
fictive, mais fonctionnelle,
Les mots de passe sont hashés avant d'êtres stockés,

Cette application utilise une base de données postgreSQL, mais peut-être changée depuis le fichier .env

## Instalation

```shell

#Une fois après avoir installé

#Création de la base de données
php bin/console doctrine:database:create

#Création de la migration
php bin/console make:migration

#Migration sur la base de données
php bin/console doctrine:migrations:migrate

#Chargement du jeu de données de test (Développement)
php bin/console doctrine:fixtures:load

```