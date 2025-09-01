<?php
include '../includes/database.php';
$id = $_GET['id'] ?? '';

$cnx = new PDO("mysql:host=localhost;dbname=$database", "root", "");
$query = $cnx->prepare("SELECT e.*,c.nom as nom_contrat , p.nom as nom_poste ,d.nom as nom_departement
FROM employe e join poste p on p.id = e.id_poste join contrat c on  c.id=e.id_contrat 
join departement d on p.id_departement = d.id where e.id = :id ");
$query->execute(['id' => $id]);
$employes = $query->fetch(PDO::FETCH_ASSOC);

$query = $cnx->prepare("SELECT date_absence,motif,nombre_jour from absence where id_employe = :id_employe ");
$query->execute(['id_employe' => $id]);
$absences = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $cnx->prepare("SELECT date_debut , date_fin , statut from conge where id_employe = :id_employe");
$query->execute(['id_employe' => $id]);
$conges = $query->fetchAll(PDO::FETCH_ASSOC);

?>
<?php
$pageTitle = "Accueil"; // Définir le titre de la page
$prefix = "../";
include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="main-panel">
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                        <div class="card-header cursor-pointer">
                            <div class="card-title m-0">
                                <h3 class="fw-bolder m-0"> Details de l'employé</h3>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-pills nav-secondary" id="pills-tab" role="tablist">
                                    <li class="nav-item submenu" role="presentation">
                                        <a class="nav-link active" id="pills-info-tab" data-bs-toggle="pill" href="#pills-info" 
                                        role="tab" aria-controls="pills-info" aria-selected="false" tabindex="-1">Infos.</a>
                                    </li>
                                    <li class="nav-item submenu" role="presentation">
                                        <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#pills-profile"
                                         role="tab" aria-controls="pills-profile" aria-selected="false" tabindex="-1">absences</a>
                                    </li>
                                    <li class="nav-item submenu" role="presentation">
                                        <a class="nav-link" id="pills-congé-tab" data-bs-toggle="pill" href="#pills-congé" 
                                        role="tab" aria-controls="pills-congé" aria-selected="true">Congés</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="">
                                    <div class="tab-pane  active show mt-2 mb-3" id="pills-info" role="tabpanel" aria-labelledby="pills-info-tab">
                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">Nom</label>
                                            <div class="col-lg-8">
                                                <span class="fw-bolder fs-6 text-gray-800"><?= $employes["nom"] ?? '' ?></span>
                                            </div>
                                        </div>

                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">Prènom</label>
                                            <div class="col-lg-8 fv-row">
                                                <span class="fw-bold text-gray-800 fs-6"><?= $employes["prenom"] ?? '' ?></span>
                                            </div>
                                        </div>

                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">la Date Naissance</label>
                                            <div class="col-lg-8 fv-row">
                                                <span class="text-gray-500 fs-6"><?= $employes["date_naissance"] ?? '' ?></span>
                                            </div>
                                        </div>

                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">Email</label>
                                            <div class="col-lg-8 fv-row">
                                                <span class="fw-bold text-gray-800 fs-6"><?= $employes["email"] ?? '' ?></span>
                                            </div>
                                        </div>

                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">Téléphone</label>
                                            <div class="col-lg-8 fv-row">
                                                <span class="fw-bold text-gray-800 fs-6"><?= $employes["telephone"] ?? '' ?></span>
                                            </div>
                                        </div>

                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">prènom</label>
                                            <div class="col-lg-8 fv-row">
                                                <span class="fw-bold text-gray-800 fs-6"><?= $employes["prenom"] ?? '' ?></span>
                                            </div>
                                        </div>

                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">Adresse</label>
                                            <div class="col-lg-8 fv-row">
                                                <span class="fw-bold text-gray-800 fs-6"><?= $employes["adresse"] ?? '' ?></span>
                                            </div>
                                        </div>

                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">Date début de Contrat</label>
                                            <div class="col-lg-8 fv-row">
                                                <span class="fw-bold text-gray-800 fs-6"><?= $employes["date_debut_contrat"] ?? '' ?></span>
                                            </div>
                                        </div>

                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">Date fin de Contrat</label>
                                            <div class="col-lg-8 fv-row">
                                                <span class="fw-bold text-gray-800 fs-6"><?= $employes["date_fin_contrat"] ?? '' ?></span>
                                            </div>
                                        </div>

                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">le type d'Employé</label>
                                            <div class="col-lg-8 fv-row">
                                                <span class="fw-bold text-gray-800 fs-6"><?= $employes["type_employe"] ?? '' ?></span>
                                            </div>
                                        </div>

                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">le pote</label>
                                            <div class="col-lg-8 fv-row">
                                                <span class="fw-bold text-gray-800 fs-6"><?= $employes["nom_poste"] ?? '' ?></span>
                                            </div>
                                        </div>

                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted">Contrat</label>
                                            <div class="col-lg-8 fv-row">
                                                <span class="fw-bold text-gray-800 fs-6"><?= $employes["nom_contrat"] ?? '' ?></span>
                                            </div>
                                        </div>

                                        <div class="row mb-7">
                                            <label class="col-lg-4 fw-bold text-muted"> Département</label>
                                            <div class="col-lg-8 fv-row">
                                                <span class="fw-bold text-gray-800 fs-6"><?= $employes["nom_departement"] ?? '' ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                        <table class="table  table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">la date d'absence</th>
                                                    <th scope="col">le nombre des jours</th>
                                                    <th scope="col">le motif d'absence</th>
                                                </tr>
                                            </thead>
                                            <?php foreach ($absences as $index => $a): ?>
                                                <tr>
                                                    <td><?= $a["date_absence"] ?? '' ?></td>
                                                    <td><?= $a["nombre_jour"] ?? '' ?></td>
                                                    <td><?= $a["motif"] ?? '' ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    </div>


                                    <div class="tab-pane fade show" id="pills-congé" role="tabpanel" aria-labelledby="pills-contact-tab">
                                        <table class="table  table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">la date début du congé</th>
                                                    <th scope="col">la date fin du congé</th>
                                                    <th scope="col">le statut de congé</th>
                                                </tr>
                                            </thead>
                                            <?php foreach ($conges as $index => $c): ?>
                                                <tr>
                                                    <td><?= $c["date_debut"] ?? '' ?></td>
                                                    <td><?= $c["date_fin"] ?? '' ?></td>
                                                    <td><?= $c["statut"] ?? '' ?></td>
                                                <?php endforeach; ?>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>




<?php include '../includes/footer.php'; ?>