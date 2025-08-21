
<?php
$pageTitle = "Départements"; 
$prefix = "../";
include '../includes/header.php';
include '../includes/sidebar.php';

$cnx = new PDO("mysql:host=localhost;dbname=entreprise_grh", "root", "");

$nomDept = $_GET['nom_departement'] ?? '';

$query = $cnx->prepare("SELECT * FROM departement WHERE nom_departement LIKE :nom");
$query->execute([
    'nom' => '%' . $nomDept . '%'
]);

$departements = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="main-panel">
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-12">
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Liste des départements</h4>
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
                                        <th scope="col">Nom Département</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <form method="get" action="">
                                            <td></td>
                                            <td>
                                                <input type="text" class="form-control input-full" 
                                                    value="<?= $nomDept ?>" name="nom_departement" 
                                                    id="nom_departement" placeholder="Nom département">
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
                                    <?php foreach ($departements as $d) : ?>
                                        <tr>
                                            <td><?= $d["id"] ?></td>
                                            <td><?= htmlspecialchars($d['nom_departement']) ?></td>
                                            <td>
                                                <a href="update.php?id=<?= $d['id'] ?>" class="btn btn-icon btn-round btn-success">
                                                    <i class="fa fa-pen fa-small"></i>
                                                </a>
                                                <a href="delete.php?id=<?= $d['id'] ?>" class="btn btn-icon btn-round btn-danger">
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
