<?php
include '../includes/database.php';
$errors = "";
$nom_departement = "";
$id = $_GET['id'] ?? '';

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (!empty($id)) {
        $conn = new PDO("mysql:host=localhost;dbname=$database;charset=utf8", "root", "");
        $query = $conn->prepare("SELECT * FROM departement WHERE id = :id");
        $query->execute(['id' => $id]);
        $departement = $query->fetch(PDO::FETCH_ASSOC);

        if ($departement) {
            $nom_departement = $departement['nom'];
        } else {
            $errors = "<div class='alert alert-danger'>Département non trouvé.</div>";
        }
    } else {
        $errors = "<div class='alert alert-danger'>ID invalide.</div>";
    }
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom_departement = $_POST['nom_departement'] ?? '';

    if (empty($nom_departement)) {
        $errors .= "<div class='alert alert-danger'>Le nom du département est requis.</div>";
    }

    $conn = new PDO("mysql:host=localhost;dbname=$database;charset=utf8", "root", "");

    if (empty($errors)) {
        try {
            // Vérifier si un autre département a déjà ce nom
            $query = $conn->prepare("SELECT nom FROM departement WHERE nom = :nom AND id != :id");
            $query->execute(['nom' => $nom_departement, "id" => $id]);
            $exists = $query->fetchAll(PDO::FETCH_ASSOC);

            if (count($exists) > 0) {
                $errors = "<div class='alert alert-danger'>Ce nom de département existe déjà.</div>";
            }
        } catch (PDOException $e) {
            $errors = "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
        }
    }

    if (empty($errors)) {
        try {
            $query = $conn->prepare("UPDATE departement SET nom = :nom WHERE id = :id");
            $query->execute([
                'nom' => $nom_departement,
                "id" => $id
            ]);

            header("Location: ../departement/listing.php", true, 302);
            exit();
        } catch (PDOException $e) {
            $errors = "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
        }
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
                <div class="col-md-8">
                    <form action="" method="post">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Modification Département</div>
                            </div>
                            <div class="card-body">

                                <div class="form-group form-inline">
                                    <label for="nom_departement" class="col-md-3 col-form-label">Nom Département</label>
                                    <input type="text" value="<?php echo htmlspecialchars($nom_departement); ?>" class="form-control input-full" id="nom_departement" name="nom_departement">
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
                                    Modifier
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
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Les erreurs</div>
                        </div>
                        <div class="card-body">
                            <?php
                            if (!empty($errors)) {
                                echo $errors;
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
