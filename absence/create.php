<?php
include '../includes/database.php';
$pageTitle = "Créer une absence"; 
$prefix = "../";
include '../includes/header.php';
include '../includes/sidebar.php';

$cnx = new PDO("mysql:host=localhost;dbname=$database", "root", "");

// Récupérer la liste des employés
$employes = $cnx->query("SELECT id, nom FROM employe")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $employe_id = $_POST['employe_id'] ?? '';
    $date_debut = $_POST['date_debut'] ?? '';
    $nb_jours = $_POST['nb_jours'] ?? '';

    if (!empty($employe_id) && !empty($date_debut) && !empty($nb_jours)) {
        $stmt = $cnx->prepare("INSERT INTO absence (employe_id, date_debut, nb_jours) 
                               VALUES (:employe_id, :date_debut, :nb_jours)");
        $stmt->execute([
            ':employe_id' => $employe_id,
            ':date_debut' => $date_debut,
            ':nb_jours'   => $nb_jours
        ]);
        header("Location: listing.php");
        exit;
    }
}
?>

<div class="main-panel">
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Ajouter une absence</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="form-group">
                                    <label for="employe_id">Employé</label>
                                    <select name="employe_id" id="employe_id" class="form-control" required>
                                        <option value="">-- Sélectionner un employé --</option>
                                        <?php foreach ($employes as $e): ?>
                                            <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['nom']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="date_debut">Date début</label>
                                    <input type="date" name="date_debut" id="date_debut" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="nb_jours">Nombre de jours</label>
                                    <input type="number" name="nb_jours" id="nb_jours" class="form-control" min="1" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                <a href="listing.php" class="btn btn-danger">Annuler</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
