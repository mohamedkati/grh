<?php
$pageTitle = "Accueil"; // Définir le titre de la page
$prefix = "../";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/database.php';
?>


<?php

$cnx = new PDO("mysql:host=localhost;dbname=$database", "root", "");

$nom = $_GET['nom'] ?? '';
$prenom = $_GET['prenom'] ?? '';
$email = $_GET['email'] ?? '';
$telephone = $_GET['telephone'] ?? '';
$id_poste = $_GET['$id_poste'] ?? '';
$id_contrat = $_GET['id_contrat'] ?? '';
$date_debut_contrat = $_GET['date_debut_contrat'] ?? '';
$id_departement = $_GET['id_departement'] ?? '';
$query = $cnx->prepare("SELECT e.id ,e.nom,e.prenom,e.email ,e.date_debut_contrat , e.id_contrat , e.id_poste ,c.nom as nom_contrat , p.nom as nom_poste FROM employe e join poste p on p.id = e.id_poste join contrat c on  c.id=e.id_contrat  where e.nom LIKE :nom AND prenom LIKE :prenom AND email LIKE :email AND telephone LIKE :telephone
AND id_poste LIKE :id_poste AND id_contrat LIKE :id_contrat AND date_debut_contrat LIKE :date_debut_contrat AND id_departement like :id_departement");
$query->execute([
    'nom' => '%' . $nom . '%',
    'prenom' => '%' . $prenom . '%',
    'email' => '%' . $email . '%',
    'telephone' => '%' . $telephone . '%',
    'id_poste' => '%' . $id_poste . '%',
    'id_contrat' => '%' . $id_contrat . '%',
    'date_debut_contrat' => '%' . $date_debut_contrat . '%',
    'id_departement' => '%' . $id_departement . '%'
]);
$employes = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $cnx->prepare("SELECT * from departement");
$query->execute();
$departements = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $cnx->prepare("SELECT * from poste");
$query->execute();
$postes = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $cnx->prepare("SELECT * from contrat");
$query->execute();
$contrats = $query->fetchAll(PDO::FETCH_ASSOC);
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
                                    <h4 class="card-title">Liste des employes</h4>
                                    <a href="create.php" class="btn btn-link btn-primary btn-round ms-auto">
                                        <i class="fa fa-plus"></i>
                                        Ajouter
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table  table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">nom</th>
                                        <th scope="col">prenom</th>
                                        <th scope="col">email</th>
                                        <th scope="col">date_debut_contrat</th>
                                        <th scope="col">contrat</th>
                                        <th scope="col">poste</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <form method="get" action="">
                                            <td></td>
                                            <td>
                                                <input type="text" class="form-control input-full" value="<?= $nom ?>"
                                                    name="nom" id="nom" placeholder="Nom">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-full" value="<?= $prenom ?>"
                                                    name="prenom" id="prenom" placeholder="Prenom">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-full" value="<?= $email ?>"
                                                    name="email" id="email" placeholder="Email">
                                            </td>
                                            <td>
                                                <select class="form-select" name="id_departement" value="<?= $id_departement ?>" id="exampleFormControlSelect1">
                                                    <option value="">Sélectionner</option>
                                                    <?php foreach ($departements as $index => $d): ?>
                                                        <option value="<?= $d['id'] ?>"> <?= $d['nom'] ?> </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            <td>
                                                <select class="form-select" name="id_contrat" value="<?= $id_contrat ?>" id="exampleFormControlSelect1">
                                                    <option value="">Sélectionner</option>
                                                    <?php foreach ($contrats as $index => $c): ?>
                                                        <option value="<?= $c['id'] ?>"> <?= $c['nom'] ?> </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-select" name="id_poste" value="<?= $id_poste ?>" id="exampleFormControlSelect1">
                                                    <option value="">Sélectionner</option>
                                                    <?php foreach ($postes as $index => $p): ?>
                                                        <option value="<?= $p['id'] ?>"> <?= $p['nom'] ?> </option>
                                                    <?php endforeach; ?>
                                                </select>
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
                                    <?php foreach ($employes as $index => $p) : ?>
                                        <tr>
                                            <td><?php echo $p["id"] ?></td>
                                            <td><?= $p['nom'] ?></td>
                                            <td><?= $p['prenom'] ?></td>>
                                            <td><?= $p['email'] ?></td>
                                            <td><?= htmlspecialchars($p['date_debut_contrat']) ?></td>
                                            <td> <?= $p['nom_contrat'] ?>
                                            <td><?= htmlspecialchars($p['nom_poste']) ?></td>
                                            <td>
                                                <a href="update.php?id=<?= $p['id'] ?>" class="btn btn-icon btn-round btn-success">
                                                    <i class="fa fa-pen fa-small"></i>
                                                </a>
                                                <a href="delete.php?id=<?= $p['id'] ?>" class="btn btn-icon btn-round btn-danger">
                                                    <i class="fa fa-trash fa-small"></i>
                                                </a>
                                                <a href="details.php" class="btn btn-secondary" style="color: white;">
                                                    Details
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php if (count($employes) == 0): ?>
                                <?= "Employé Indiponible" ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include '../includes/footer.php'; ?>