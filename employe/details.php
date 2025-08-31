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
                                <h3 class="fw-bolder m-0">Profile Details</h3>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"></h4>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-pills nav-secondary" id="pills-tab" role="tablist">
                                    <li class="nav-item submenu" role="presentation">
                                        <a class="nav-link" id="pills-home-tab" data-bs-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="false" tabindex="-1">les infos d'employé</a>
                                    </li>
                                    <li class="nav-item submenu" role="presentation">
                                        <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false" tabindex="-1">Absence</a>
                                    </li>
                                    <li class="nav-item submenu" role="presentation">
                                        <a class="nav-link active" id="pills-congé-tab" data-bs-toggle="pill" href="#pills-congé" role="tab" aria-controls="pills-congé" aria-selected="true">Congé</a>
                                    </li>
                                </ul>
                                <div class="tab-content mt-2 mb-3" id="pills-tabContent">
                                    <div class="tab-pane fade" id="pills-employe" role="tabpanel" aria-labelledby="pills-employe-tab">
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
                                                <span class="fw-bold text-gray-800 fs-6"><?= $employes["date_naissance"] ?? '' ?></span>
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

                                    </div>
                                    <div class="tab-pane fade active show" id="pills-congé" role="tabpanel" aria-labelledby="pills-contact-tab">
                                        <?php foreach ($conges as $index => $c): ?>
                                            <div class="row mb-7">
                                                <label class="col-lg-4 fw-bold text-muted">la date debut du congé</label>
                                                <div class="col-lg-8 fv-row">
                                                    <span class="fw-bold text-gray-800 fs-6"><?= $c["date_debut"] ?? '' ?></span>
                                                </div>
                                            </div>
                                            <div class="row mb-7">
                                                <label class="col-lg-4 fw-bold text-muted">la date fin du congé</label>
                                                <div class="col-lg-8 fv-row">
                                                    <span class="fw-bold text-gray-800 fs-6"><?= $c["date_fin"] ?? '' ?></span>
                                                </div>
                                            </div>
                                            <div class="row mb-7">
                                                <label class="col-lg-4 fw-bold text-muted">le statut de congé</label>
                                                <div class="col-lg-8 fv-row">
                                                    <span class="fw-bold text-gray-800 fs-6"><?= $c["statut"] ?? '' ?></span>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        l-lg-8 fv-row">
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
          

                            <?php foreach ($absences as $index => $a): ?>
                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-bold text-muted">la date d'absence</label>
                                    <div class="col-lg-8 fv-row">
                                        <span class="fw-bold text-gray-800 fs-6"><?= $a["date_absence"] ?? '' ?></span>
                                    </div>
                                </div>
                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-bold text-muted">le nombre des jours</label>
                                    <div class="col-lg-8 fv-row">
                                        <span class="fw-bold text-gray-800 fs-6"><?= $a["nombre_jour"] ?? '' ?></span>
                                    </div>
                                </div>
                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-bold text-muted">le Motif d'absence</label>
                                    <div class="col-lg-8 fv-row">
                                        <span class="fw-bold text-gray-800 fs-6"><?= $a["motif"] ?? '' ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!--end::Card body-->
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>




<?php include '../includes/footer.php'; ?>