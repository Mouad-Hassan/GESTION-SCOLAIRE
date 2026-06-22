# 🎓 Gestion Scolaire — Application PHP/PDO

Application web de gestion scolaire développée en **PHP** avec **PDO** .

---

## 📁 Structure du projet

```
GESTION-SCOLAIRE/
│
├── assets/
│   └── css/
│       └── style.css          ← Styles personnalisés
├── config/
│   └── database.php           ← Connexion PDO (à configurer)
├── includes/
│   ├── header.php             
│   ├── navbar.php             ← Barre de navigation
│   └── footer.php             ← Pied de page
├── pages/
│   ├── eleve/
│   │   ├── index.php          ← Liste des élèves
│   │   ├── create.php         ← Ajouter un élève
│   │   ├── edit.php           ← Modifier un élève
│   │   └── delete.php         ← Supprimer un élève
│   ├── enseignant/
│   │   ├── index.php
│   │   ├── create.php
│   │   ├── edit.php
│   │   └── delete.php
│   ├── classe/
│   │   ├── index.php
│   │   ├── create.php
│   │   ├── edit.php
│   │   └── delete.php
│   ├── matiere/
│   │   ├── index.php
│   │   ├── create.php
│   │   ├── edit.php
│   │   └── delete.php
│   ├── inscription/
│   │   ├── index.php
│   │   ├── create.php
│   │   ├── edit.php
│   │   └── delete.php
│   ├── affectation/
│   │   ├── index.php
│   │   ├── create.php
│   │   ├── edit.php
│   │   └── delete.php
│   └── index.php                 
├── gestion_scolaire.sql       
└── README.md                  


## 🚀 Installation

1. **Prérequis** : XAMPP/WAMP avec PHP  et MySQL
2. **Base de données** : Importer `gestion_scolaire.sql` dans phpMyAdmin
3. **Configuration** : Modifier `config/database.php` si nécessaire
4. **Accès** : Placer le dossier dans `htdocs/` et accéder via `http://localhost/gestion_scolaire/`

## 📋 Entités gérées

| Entité | Description |
|--------|-------------|
| **Élèves** | Matricule unique, informations personnelles |
| **Enseignants** | Matricule + email uniques, spécialités |
| **Classes** | Nom unique par année, capacité maximale |
| **Matières** | Code unique, coefficient |
| **Inscriptions** | Rattachement élève-classe-année |
| **Affectations** | Enseignant-classe-matière |

## 🔒 Sécurité

- ✅ Requêtes préparées PDO (anti-injection SQL)
- ✅ `htmlspecialchars()` sur toutes les sorties (anti-XSS)
- ✅ Validation serveur des données
- ✅ Messages d'erreur sans détails techniques
- ✅ Contraintes d'intégrité référentielle (FK)

## 📝 Règles de gestion respectées

- Un élève = un matricule unique
- Un enseignant = matricule + email uniques
- Une classe = nom unique par année scolaire
- Capacité maximale respectée lors des inscriptions
- Une matière ne peut être affectée qu'une fois au même enseignant dans la même classe
- Suppression protégée par intégrité référentielle

