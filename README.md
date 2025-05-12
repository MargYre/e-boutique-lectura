# Lectura – Symfony E-Boutique

Boutique en ligne développée avec Symfony. L'application permet de consulter, ajouter et commander des livres, BD et mangas.  
Paiement non intégré.

## Installation rapide

```bash
git clone git@github.com:MargYre/e-boutique-lectura.git
cd e-boutique-lectura
composer install
php bin/console doctrine:database:create
mysql -u [user] -p e_boutique_lectura < assets/sql/initial_data.sql
composer require twig/intl-extra twig/string-extra
```

---

## ▶️ Lancer le projet

```bash
symfony server:start
```

---

##  Accès

- Front : http://localhost:8000  
- Démo : `plop@plop.fr` / `plop` 
- compte admin : `admin@admin.fr` / `admin`

---

## Fonctionnalités

- Navigation par **catégorie**
- Fiches produit détaillées
- Connexion & déconnexion
- Inscription
- Panier avec gestion des quantités
- Page de paiment
- Gestion du profil
- Interface **admin** pour gérer le catalogue

---