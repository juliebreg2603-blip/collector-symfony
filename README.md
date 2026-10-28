# Collector

Site e-commerce de collection développé avec Symfony : vinyles, CD et œuvres d'art, avec comptes utilisateurs, panier et commandes.

## Technologies
- PHP 8.2+, Symfony 7.4, Twig
- Doctrine ORM et migrations, MySQL
- Symfony Security (authentification, rôles), Symfony Forms et Validator
- VichUploaderBundle (envoi d'images)

## Fonctionnalités
- Inscription, connexion et page de profil
- Gestion des rôles : utilisateur (`ROLE_USER`), artiste (`ROLE_ARTIST`) et administrateur (`ROLE_ADMIN`), avec des droits d'accès différents selon le profil
- Catalogue de produits par catégories : vinyles, CD, art
- Création, modification et suppression de produits et de catégories (selon le rôle)
- Panier (ajout, retrait, suppression, vidage) et validation de commande
- Historique des commandes ("Mes commandes")
- Page de blind test

## Lancer le projet
1. Cloner le dépôt puis installer les dépendances :
   ```bash
   composer install
   ```
2. Copier `.env` en `.env.local` et y renseigner votre `DATABASE_URL` et votre `APP_SECRET`.
3. Créer la base et appliquer les migrations :
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```
4. Démarrer le serveur :
   ```bash
   symfony server:start
   ```
   (ou placer le projet dans le dossier `www` de WAMP).

## Auteure
Julie Bregman
