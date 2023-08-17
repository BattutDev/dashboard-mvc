# Gestion de stockage

Application PHP MVC de gestion de stockage, 
fictive, mais fonctionnelle,
Les mots de passe sont hashés avant d'êtres stockés,

Cette application utilise une base de données postgreSQL, mais peut-être changée

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