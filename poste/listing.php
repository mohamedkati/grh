<?php
include '../includes/database.php';
$pageTitle = "Accueil"; // Définir le titre de la page
$prefix = "../";
include '../includes/header.php';
include '../includes/sidebar.php';
?>


<?php
$cnx = new PDO("mysql:host=localhost;dbname=$database", "root", "");
$nom_poste = $_GET['nom_poste'] ?? '';
$query = $cnx->prepare("SELECT p.id,p.nom,d.nom as nom_departement FROM poste p inner join departement d
on p.id_departement=d.id where p.nom LIKE :nom_poste ");
$query->execute([
  'nom_poste' => '%' . $nom_poste . '%'
]);
$postes = $query->fetchAll(PDO::FETCH_ASSOC);
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
                                    <h4 class="card-title">Liste des postes</h4>
                                    <a href="create.php" class="btn btn-link btn-primary btn-round ms-auto">
                                        <i class="fa fa-plus"></i>
                                        Ajouter
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-head-bg-primary mt-4">
                      <thead>
                        <tr>
                          <th scope="col">id</th>
                          <th scope="col">le nom du poste</th>
                          <th scope="col">le nom de departement</th>
                          <th scope="col">Actions</th>
                        </tr>
                        <tr>
                          <form method="GET" action="">
                          <td>
                                               
                          </td>
                          <td><input type="text" class="form-control input-full" value="<?= $nom_poste ?>" name="nom_poste" id="nom_poste" placeholder=" poste name"></td>
                          <td></td>
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
                      </thead>
                      <tbody>
                        <?php foreach ($postes as $index => $po) : ?>
                                        <tr>
                                            <td><?= $po["id"] ?></td>
                                            <td><?= $po['nom'] ?></td>
                                            <td><?= $po['nom_departement'] ?></td>
                                            
                                            <td>
                                                <a href="update.php?id_poste=<?= $po['id'] ?>" class="btn btn-icon btn-round btn-success">
                                                    <i class="fa fa-pen fa-small"></i>
                                                </a>
                                                <a href="delete.php?id_poste=<?= $po['id'] ?>" class="btn btn-icon btn-round btn-danger">
                                                    <i class="fa fa-trash fa-small"></i>
                                                </a>
                                            </td>
                                        </tr>
                       <?php endforeach; ?>
                      </tbody>
                    </table>
                    <?php if (count($postes) == 0): ?>
                                 <?= "Poste Indiponible" ?>
                    <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include '../includes/footer.php'; ?>