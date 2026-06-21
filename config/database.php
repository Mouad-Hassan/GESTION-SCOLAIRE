<?php
$serveur = "localhost";
$nom_base = "gestion_scolaire";
$utilisateur = "root";
$mot_de_passe = "";

function getDBConnection() {
    global $serveur, $nom_base, $utilisateur, $mot_de_passe;
    try {
        $connexion = new PDO(
            "mysql:host=$serveur;dbname=$nom_base;charset=utf8",
            $utilisateur,
            $mot_de_passe
        );
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connexion;
    } catch(PDOException $erreur) {
        die("Erreur de connexion : " . $erreur->getMessage());
    }
}
?>