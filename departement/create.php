<?php
include '../includes/database.php';
$data = "";
$nom_departement = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom_departement = $_POST['nom_departement'] ?? '';

    // Vérification du champ obligatoire
    if (empty($nom_departement)) {
        $data .= "<div class='alert alert-danger'>Le nom du département est requis.</div>";
    }

    // Connexion DB
    $conn = new PDO("mysql:host=localhost;dbname=$database;charset=utf8", "root", "");

    // Vérifier si le département existe déjà
    if (empty($data)) {
        $query = $conn->prepare("SELECT nom FROM departement WHERE nom = :nom_departement");
        $query->execute([':nom_departement' => $nom_departement]);
        $exists = $query->fetch();

        if ($exists) {
            $data = "<div class='alert alert-danger'>Ce département existe déjà.</div>";
        }
    }

    // Si pas d'erreurs → insertion
    if (empty($data)) {
        $query = $conn->prepare("INSERT INTO departement (nom) VALUES (:nom_departement)");
        $query->execute([':nom_departement' => $nom_departement]);

        header("Location: ../departement/listing.php");
        exit();
    }
}
?>

<?php
$pageTitle = "Départements"; 
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
                                <div class="card-title">Créer Département</div>
                            </div>
                            <div class="card-body">

                                <div class="form-group form-inline">
                                    <label for="nom_departement" class="col-md-3 col-form-label">Nom Département</label>
                                    <input type="text" 
                                           value="<?php echo htmlspecialchars($nom_departement); ?>" 
                                           class="form-control input-full" 
                                           id="nom_departement" 
                                           name="nom_departement" 
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
