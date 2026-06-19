<?php

$pageTitle="Enseignant";

require_once "../../config/database.php";
require_once "../../includes/header.php";
require_once "../../includes/navbar.php";

$pdo = getDBConnection();

$enseignants = $pdo->query("
    SELECT *
    FROM enseignant
    ORDER BY id_enseignant DESC
")->fetchAll();
?>

<div class="container">

    <div class="card">

        <div class="card-header d-flex justify-content-between">
            <span>Liste enseignants</span>

            <a href="create.php" class="btn btn-success">
                Ajouter
            </a>
        </div>


        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th>Matricule</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Spécialité</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Actions</th>
                </tr>


                <?php foreach($enseignants as $e): ?>

                <tr>

                    <td>
                        <?= htmlspecialchars($e['matricule']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($e['nom']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($e['prenom']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($e['specialite']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($e['email']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($e['telephone']) ?>
                    </td>


                    <td>

                        <a href="edit.php?id=<?= $e['id_enseignant'] ?>"
                           class="btn btn-warning btn-sm">
                            Modifier
                        </a>


                        <form method="POST"
                              action="delete.php"
                              style="display:inline">

                            <input type="hidden"
                                   name="id"
                                   value="<?= $e['id_enseignant'] ?>">


                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Voulez-vous supprimer cet enseignant ?')">

                                Supprimer

                            </button>

                        </form>


                    </td>

                </tr>


                <?php endforeach; ?>


            </table>

        </div>

    </div>

</div>


<?php require_once "../../includes/footer.php"; ?>