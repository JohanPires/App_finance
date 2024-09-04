# Projet Laravel

## Table des Matières

-   [À propos](#à-propos)
-   [Prérequis](#prérequis)
-   [Installation](#installation)
-   [Configuration](#configuration)
-   [Migration de la base de données](#migration-de-la-base-de-données)
-   [Démarrage du serveur de développement](#démarrage-du-serveur-de-développement)
-   [Authentification avec Laravel Sanctum](#authentification-avec-laravel-sanctum)
-   [Génération de la documentation API avec Swagger](#génération-de-la-documentation-api-avec-swagger)
-   [Tests](#tests)
-   [Contribution](#contribution)
-   [Licence](#licence)

## À propos

Ce projet est une application Laravel conçue pour [décrire les fonctionnalités principales de l'application]. Il utilise Laravel Sanctum pour l'authentification par jeton et Swagger pour la documentation de l'API.

## Prérequis

Avant de commencer, assurez-vous d'avoir les outils suivants installés sur votre machine :

-   [PHP 8.x](https://www.php.net/downloads)
-   [Composer](https://getcomposer.org/download/)
-   [MySQL](https://dev.mysql.com/downloads/) ou un autre système de gestion de base de données compatible
-   [Git](https://git-scm.com/downloads)

## Installation

1. Clonez le dépôt Git :

    ```bash
    git clone https://github.com/JohanPires/App_finance.git
    cd app-finance-back
    ```

2. Installer composer :

    ```bash
    composer install
    ```

## Migration

1. Lancer la migration de la base de donnée :

    ```bash
    php artisan migrate
    ```

2. Lancer le seeder :

    ```bash
    php artisan db:seed
    ```

## Démarrer le server

1. Commande pour lancer le server :

    ```bash
    php artisan serve
    ```
