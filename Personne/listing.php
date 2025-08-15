<?php
$pageTitle = "Accueil"; // Définir le titre de la page
$prefix = "../";
include '../includes/header.php';
include '../includes/sidebar.php';
?>
<?php

$cnx = new PDO("mysql:host=localhost;dbname=testdb", "root", "");

$query = $cnx->prepare("SELECT * FROM personne");
$query->execute();
$personnes = $query->fetchAll(PDO::FETCH_ASSOC);



?>

<div class="main-panel">
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Liste des peronnes</h4>
                                    <a href="create.php" class="btn btn-link btn-primary btn-round ms-auto">
                                        <i class="fa fa-plus"></i>
                                        Ajouter
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Fullname</th>
                                        <th scope="col">Ville</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Date naissance</th>
                                        <th scope="col">Adresse</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($personnes as $index => $p) : ?>
                                        <tr>
                                            <td><?php echo $p["Id"] ?></td>
                                            <td><?= $p['FullName'] ?></td>
                                            <td><?= htmlspecialchars($p['Ville']) ?></td>
                                            <td><?= htmlspecialchars($p['Email']) ?></td>
                                            <td><?= htmlspecialchars($p['DateNaissance']) ?></td>
                                            <td><?= htmlspecialchars($p['Adresse']) ?></td>
                                            <td>
                                                <a href="update.php?id=<?= $p['Id'] ?>" class="btn btn-icon btn-round btn-success">
                                                    <i class="fa fa-pen fa-small"></i>
                                                </a>
                                                <a href="delete.php?id=<?= $p['Id'] ?>" class="btn btn-icon btn-round btn-danger">
                                                    <i class="fa fa-trash fa-small"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include '../includes/footer.php'; ?>