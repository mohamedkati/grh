<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_poste = $_POST['id_poste'] ?? '';
    if (!empty($id_poste)) {
        $conn = new PDO("mysql:host=localhost;dbname=gestion_rh", "root", "");
        $query = $conn->prepare("DELETE FROM poste WHERE id_poste = :id_poste");
        $query->execute(['id_poste' => $id_poste]);
        header("Location: listing.php", true, 301);
        exit();
    }
}

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
                <div class="col-3"></div>
                <div class="col-6">
                    <div class="alert alert-danger">
                        <div class="flex">
                            <h3> <i class="fa fa-exclamation-triangle"></i>
                                <span class="ms-2">Suppression de poste</span>
                            </h3>

                        </div>
                        <div class="flex flex-items">
                            <h4><strong>Attention!</strong> Voulez-vous vraiment supprimer ce poste ?</h4>
                        </div>

                        <div class="flex flex-center">
                            <form action="" method="post">
                                <input type="hidden" name="id_poste" value="<?= $_GET['id_poste'] ?>">
                                <button type="submit" class="btn btn-danger">Oui, supprimer</button>
                                <a href="listing.php" class="btn btn-secondary">Annuler</a>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="offset-3"></div>
            </div>
        </div>
    </div>
</div>


<?php include '../includes/footer.php'; ?>