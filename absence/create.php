<?php
// Connexion DB
include '../includes/database.php';
$cnx = new PDO("mysql:host=localhost;dbname=$database", "root", "");
$data = "";

// === Traitement formulaire avant أي HTML ===
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_employe   = $_POST['id_employe'] ?? '';
    $date_absence = $_POST['date_absence'] ?? '';
    $motif        = $_POST['motif'] ?? '';

    // Vérification des champs
    if (empty($id_employe) || empty($date_absence) || empty($motif)) {
        $data = "<div class='alert alert-danger'>Tous les champs sont obligatoires.</div>";
    } else {
        // Insertion
        $stmt = $cnx->prepare("INSERT INTO absence (id_employe, date_absence, motif) 
                               VALUES (:id_employe, :date_absence, :motif)");
        $stmt->execute([
            ':id_employe'   => $id_employe,
            ':date_absence' => $date_absence,
            ':motif'        => $motif
        ]);

        // Redirection vers listing
        header("Location: listing.php");
        exit();
    }
}

// === Charger employés pour le <select> ===
$employes = $cnx->query("SELECT id, nom FROM employe")->fetchAll(PDO::FETCH_ASSOC);

// === Inclure header & sidebar après traitement ===
$pageTitle = "Ajouter Absence";
$prefix = "../";
include '../includes/header.php';
include '../includes/sidebar.php';
?>


<div class="main-panel">
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Nouvelle Absence</h4>
                        </div>
                        <div class="card-body">
                            <?= $data ?>
                            <form method="POST">
                                <div class="form-group">
                                    <label for="id_employe">Employé</label>
                                    <select class="form-control" name="id_employe" id="id_employe" required>
                                        <option value="">-- Choisir un employé --</option>
                                        <?php foreach ($employes as $emp): ?>
                                            <option value="<?= $emp['id'] ?>"><?= htmlspecialchars($emp['nom']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="date_absence">Date Absence</label>
                                    <input type="date" class="form-control" id="date_absence" name="date_absence" required>
                                </div>
                                <div class="form-group">
                                    <label for="motif">Motif</label>
                                    <input type="text" class="form-control" id="motif" name="motif" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    <a href="listing.php" class="btn btn-danger">Annuler</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>