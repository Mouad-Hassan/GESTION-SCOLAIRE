# 🎓 Gestion Scolaire — Application PHP/PDO

Application web de gestion scolaire développée en **PHP 8** avec **PDO** et **Bootstrap 5**.

---

## 📁 Structure du projet

```
GESTION-SCOLAIRE/
│
├── assets/
│   └── css/
│       └── style.css          ← Styles personnalisés
│
├── config/
│   └── database.php           ← Connexion PDO (à configurer)
│
├── includes/
│   ├── header.php             ← DOCTYPE + <head> + Bootstrap
│   ├── navbar.php             ← Barre de navigation
│   └── footer.php             ← Pied de page
│
├── pages/
│   ├── eleve/
│   │   ├── index.php          ← Liste des élèves
│   │   ├── create.php         ← Ajouter un élève
│   │   ├── edit.php           ← Modifier un élève
│   │   └── delete.php         ← Supprimer un élève
│   │
│   ├── enseignant/
│   │   ├── index.php
│   │   ├── create.php
│   │   ├── edit.php
│   │   └── delete.php
│   │
│   ├── classe/
│   │   ├── index.php
│   │   ├── create.php
│   │   ├── edit.php
│   │   └── delete.php
│   │
│   ├── matiere/
│   │   ├── index.php
│   │   ├── create.php
│   │   ├── edit.php
│   │   └── delete.php
│   │
│   ├── inscription/
│   │   ├── index.php
│   │   ├── create.php
│   │   ├── edit.php
│   │   └── delete.php
│   │
│   └── affectation/
│       ├── index.php
│       ├── create.php
│       ├── edit.php
│       └── delete.php
│
├── index.php                  ← Tableau de bord (page d'accueil)
├── gestion_scolaire.sql       ← Base de données MySQL/MariaDB
└── README.md                  ← Ce fichier
```

---

## ⚙️ Installation

### 1. Prérequis
- **XAMPP** (ou WAMP/MAMP) avec PHP 8+ et MariaDB
- Navigateur web

### 2. Copier le projet
Copie le dossier dans :
```
C:\xampp\htdocs\gestion-scolaire\
```

### 3. Créer la base de données
1. Ouvre **phpMyAdmin** → `http://localhost/phpmyadmin`
2. Clique sur **Importer**
3. Sélectionne le fichier `gestion_scolaire.sql`
4. Clique sur **Exécuter**

### 4. Vérifier la connexion
Ouvre `config/database.php` et vérifie :
```php
$serveur    = "localhost";
$nom_base   = "gestion_scolaire";
$utilisateur= "root";
$mot_de_passe = "";      // vide par défaut sur XAMPP
```

### 5. Lancer l'application
Ouvre dans ton navigateur :
```
http://localhost/gestion-scolaire/
```

---

## 🗄️ Base de données

### Tables

| Table | Description |
|-------|-------------|
| `eleve` | Élèves inscrits |
| `enseignant` | Professeurs |
| `classe` | Classes (1A, 2A…) |
| `matiere` | Matières enseignées |
| `inscription` | Lien élève ↔ classe |
| `affectation` | Lien enseignant ↔ classe ↔ matière |

### Relations

```
eleve ──────────── inscription ──────────── classe
                                               │
enseignant ──── affectation ──── matiere ──────┘
```

---

## 🧩 Concepts PDO utilisés

### Connexion
```php
$pdo = new PDO("mysql:host=localhost;dbname=gestion_scolaire;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
```

### Lire tous les enregistrements
```php
$stmt  = $pdo->query("SELECT * FROM eleve");
$eleves = $stmt->fetchAll(PDO::FETCH_ASSOC);
```

### Lire un seul enregistrement (avec paramètre)
```php
$stmt = $pdo->prepare("SELECT * FROM eleve WHERE id_eleve = :id");
$stmt->execute([':id' => $id]);
$eleve = $stmt->fetch(PDO::FETCH_ASSOC);
```

### Insérer
```php
$stmt = $pdo->prepare("INSERT INTO eleve (nom, prenom) VALUES (:nom, :prenom)");
$stmt->execute([':nom' => 'Alaoui', ':prenom' => 'Yassine']);
```

### Modifier
```php
$stmt = $pdo->prepare("UPDATE eleve SET nom = :nom WHERE id_eleve = :id");
$stmt->execute([':nom' => 'Bennani', ':id' => 3]);
```

### Supprimer
```php
$stmt = $pdo->prepare("DELETE FROM eleve WHERE id_eleve = :id");
$stmt->execute([':id' => 3]);
```

---

## ⚠️ Points importants

### Sécurité — toujours utiliser `prepare()`
```php
// ❌ DANGEREUX — injection SQL possible
$pdo->query("SELECT * FROM eleve WHERE id = " . $_GET['id']);

// ✅ SÉCURISÉ — paramètre lié
$stmt = $pdo->prepare("SELECT * FROM eleve WHERE id_eleve = :id");
$stmt->execute([':id' => (int)$_GET['id']]);
```

### Affichage — toujours utiliser `htmlspecialchars()`
```php
// Empêche les attaques XSS
echo htmlspecialchars($eleve['nom']);
```

### Redirection après action
```php
// Après INSERT / UPDATE / DELETE
header('Location: index.php');
exit; // ⚠️ obligatoire après header()
```

### Ordre de suppression (Foreign Keys)
Avant de supprimer un enregistrement parent, supprimer ses enfants :
```
Supprimer un élève     → supprimer ses inscriptions d'abord
Supprimer un enseignant → supprimer ses affectations d'abord
Supprimer une classe   → supprimer inscriptions + affectations
Supprimer une matière  → supprimer ses affectations d'abord
```

---

## 🛠️ Technologies

- **PHP 8** — langage serveur
- **PDO** — accès à la base de données (sécurisé)
- **MariaDB 10** — base de données
- **Bootstrap 5** — interface graphique responsive
- **XAMPP** — serveur local de développement

---

*Projet réalisé à des fins pédagogiques — Gestion Scolaire © 2026*