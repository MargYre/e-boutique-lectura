# 📚 Lectura – Symfony E-Boutique

Boutique en ligne développée avec **Symfony** dans le cadre d’un projet de formation. Elle permet de consulter, ajouter et commander des livres, BD et mangas.  
⚠️ Paiement non intégré.

---

## ⚙️ Prérequis
- PHP 8.1+
- Composer
- MySQL 8.0+
- Symfony CLI

---

## 🚀 Installation rapide

```bash
git clone [votre-repo]
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

## 🔑 Accès

- Front : http://localhost:8000  
- Démo : `plop@plop.fr` / `plop` 

---

## 📦 Fonctionnalités

- Navigation par **catégorie**
- Fiches produit détaillées
- Connexion & déconnexion
- Inscription
- Panier

## A venir...
- **Panier** avec gestion des quantités
- Récapitulatif de commande
- Gestion du profil
- Interface **admin** pour gérer le catalogue

---