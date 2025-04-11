# E-Boutique Symfony - Librairie

## Prérequis techniques
- PHP 8.1+
- Composer
- MySQL 8.0+
- Symfony CLI

## Installation

### 1. Configuration initiale
```bash
git clone [votre-repo]
cd e-boutique-lectura
composer install

2. Configuration de la base de données
Créez votre base de données :

bash
Copy
php bin/console doctrine:database:create
Importez les données initiales :

bash
Copy
mysql -u votre_utilisateur -p e_boutique_lectura < assets/sql/initial_data.sql
➡️ Identifiants par défaut (à modifier dans .env si besoin) :

Utilisateur : lectura_user

Mot de passe : test1234

3. Extensions Twig nécessaires
bash
Copy
composer require twig/intl-extra twig/string-extra
Structure des données
Le fichier initial contient :

3 catégories (Roman, BD, Scolaire)

9 livres (3 par catégorie)

Commandes utiles
Commande	Description
php bin/console server:run	Lance le serveur de développement
php bin/console doctrine:migrations:migrate	Applique les migrations
php bin/console cache:clear	Vide le cache
Accès
Frontend : http://localhost:8000

Compte admin : admin@example.com / password