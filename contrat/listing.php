<?php
include '../includes/database.php';
$pageTitle = "Contrats"; 
$prefix = "../";
include '../includes/header.php';
include '../includes/sidebar.php';

$cnx = new PDO("mysql:host=localhost;dbname=$database", "root", "");

$nomContrat = $_GET['nom_contrat'] ?? '';

$query = $cnx->prepare("SELECT * FROM contrat WHERE nom LIKE :nom");
$query->execute([
    'nom' => '%' . $nomContrat . '%'
]);

$contrats = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="main-panel">
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title d-flex align-items-center">
                                <h4 class="card-title">Liste des contrats</h4>
                                <a href="create.php" class="btn btn-link btn-primary btn-round ms-auto">
                                    <i class="fa fa-plus"></i>
                                    Ajouter
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Nom Contrat</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <form method="get" action="">
                                            <td></td>
                                            <td>
                                                <input type="text" class="form-control input-full" 
                                                    value="<?= htmlspecialchars($nomContrat) ?>" name="nom_contrat" 
                                                    id="nom_contrat" placeholder="Nom contrat">
                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-icon btn-round btn-info">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                                <a href="listing.php" class="btn btn-icon btn-round btn-black">
                                                    <i class="fa fa-times fa-small"></i>
                                                </a>
                                            </td>
                                        </form>
                                    </tr>
                                    <?php foreach ($contrats as $c) : ?>
                                        <tr>
                                            <td><?= $c["id"] ?></td>
                                            <td><?= htmlspecialchars($c['nom']) ?></td>
                                            <td>
                                                <a href="update.php?id=<?= $c['id'] ?>" class="btn btn-icon btn-round btn-success">
                                                    <i class="fa fa-pen fa-small"></i>
                                                </a>
                                                <a href="delete.php?id=<?= $c['id'] ?>" class="btn btn-icon btn-round btn-danger">
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
