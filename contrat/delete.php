<?php
include '../includes/database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'] ?? '';
    if (!empty($id)) {
        $conn = new PDO("mysql:host=localhost;dbname=$database;charset=utf8", "root", "");
        $query = $conn->prepare("DELETE FROM contrat WHERE id = :id");
        $query->execute(['id' => $id]);
        header("Location: listing.php", true, 301);
        exit();
    }
}
?>

<?php
$pageTitle = "Contrats"; 
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
                                <span class="ms-2">Suppression du contrat</span>
                            </h3>
                        </div>
                        <div class="flex flex-items">
                            <h4><strong>Attention!</strong> Voulez-vous vraiment supprimer ce contrat ?</h4>
                        </div>

                        <div class="flex flex-center">
                            <form action="" method="post">
                                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
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
