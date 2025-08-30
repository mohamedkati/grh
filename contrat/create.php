<?php
include '../includes/database.php';
$data = "";
$nom_contrat = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom_contrat = $_POST['nom_contrat'] ?? '';

    // Vérification du champ obligatoire
    if (empty($nom_contrat)) {
        $data .= "<div class='alert alert-danger'>Le nom du contrat est requis.</div>";
    }

    // Connexion DB
    $conn = new PDO("mysql:host=localhost;dbname=$database;charset=utf8", "root", "");

    // Vérifier si le contrat existe déjà
    if (empty($data)) {
        $stmt = $conn->prepare("SELECT * FROM contrat WHERE nom = :nom");
        $stmt->execute([':nom' => $nom_contrat]);
        $exists = $stmt->fetch();

        if ($exists) {
            $data = "<div class='alert alert-danger'>Ce contrat existe déjà.</div>";
        }
    }

    // Si pas d'erreurs → insertion
    if (empty($data)) {
        $stmt = $conn->prepare("INSERT INTO contrat (nom) VALUES (:nom)");
        $stmt->execute([':nom' => $nom_contrat]);

        header("Location: listing.php");
        exit();
    }
}
?>

<?php
$pageTitle = "Créer Contrat"; 
$prefix = "../";
include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="main-panel">
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-6">
                    <form action="" method="post">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Créer Contrat</div>
                            </div>
                            <div class="card-body">

                                <div class="form-group form-inline">
                                    <label for="nom_contrat" class="col-md-3 col-form-label">Nom Contrat</label>
                                    <input type="text" 
                                           value="<?php echo htmlspecialchars($nom_contrat); ?>" 
                                           class="form-control input-full" 
                                           id="nom_contrat" 
                                           name="nom_contrat" 
                                           required>
                                </div>

                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Actions</div>
                            </div>
                            <div class="card-body">
                                <button type="submit" class="btn btn-secondary">
                                    <span class="btn-label">
                                        <i class="fa fa-plus"></i>
                                    </span>
                                    Ajouter
                                </button>
                                <a href="listing.php" class="btn btn-black" style="color: white;">
                                    <span class="btn-label">
                                        <i class="fa fa-archive"></i>
                                    </span>
                                    Annuler
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Affichage des erreurs -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Les erreurs</div>
                        </div>
                        <div class="card-body">
                            <?php
                            if (!empty($data)) {
                                echo $data;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
