<?php
include '../includes/database.php';

$data = "";
$id_employe = "";
$date_debut = "";
$date_fin = "";

// Connexion à la DB
try {
    $conn = new PDO("mysql:host=localhost;dbname=$database;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Récupérer la liste des employés
try {
    $employes = $conn->query("SELECT id, nom FROM employe")->fetchAll();
} catch(PDOException $e) {
    die("Erreur lors de la récupération des employés : " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_employe = $_POST['id_employe'] ?? '';
    $date_debut = $_POST['date_debut'] ?? '';
    $date_fin = $_POST['date_fin'] ?? '';

    // Vérification des champs
    if (empty($id_employe) || empty($date_debut) || empty($date_fin)) {
        $data = "<div class='alert alert-danger'>Tous les champs sont requis.</div>";
    } elseif ($date_fin < $date_debut) {
        $data = "<div class='alert alert-danger'>La date de fin doit être après la date de début.</div>";
    }

    if (empty($data)) {
        try {
            $stmt = $conn->prepare("INSERT INTO conge (id_employe, date_debut, date_fin, statut) 
                                    VALUES (:id_employe, :date_debut, :date_fin, 'en cours')");
            $stmt->execute([
                ':id_employe' => $id_employe,
                ':date_debut' => $date_debut,
                ':date_fin'   => $date_fin
            ]);
            header("Location: listing.php");
            exit();
        } catch(PDOException $e) {
            $data = "<div class='alert alert-danger'>Erreur lors de l'enregistrement : " . $e->getMessage() . "</div>";
        }
    }
}
?>

<?php
$pageTitle = "Demande de Congé"; 
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
                                <div class="card-title">Demander un Congé</div>
                            </div>
                            <div class="card-body">
                                <div class="form-group form-inline">
                                    <label for="id_employe" class="col-md-3 col-form-label">Employé</label>
                                    <select name="id_employe" id="id_employe" class="form-control input-full" required>
                                        <option value="">-- Choisir Employé --</option>
                                        <?php foreach($employes as $emp): ?>
                                            <option value="<?= $emp['id']; ?>" <?= ($id_employe == $emp['id']) ? 'selected' : ''; ?>>
                                                <?= htmlspecialchars($emp['nom']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group form-inline">
                                    <label for="date_debut" class="col-md-3 col-form-label">Date début</label>
                                    <input type="date" value="<?= htmlspecialchars($date_debut); ?>" class="form-control input-full" id="date_debut" name="date_debut" required>
                                </div>

                                <div class="form-group form-inline">
                                    <label for="date_fin" class="col-md-3 col-form-label">Date fin</label>
                                    <input type="date" value="<?= htmlspecialchars($date_fin); ?>" class="form-control input-full" id="date_fin" name="date_fin" required>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Actions</div>
                            </div>
                            <div class="card-body">
                                <button type="submit" class="btn btn-secondary">
                                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                                    Envoyer Demande
                                </button>
                                <a href="listing.php" class="btn btn-black" style="color: white;">
                                    <span class="btn-label"><i class="fa fa-archive"></i></span>
                                    Annuler
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Les erreurs</div>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($data)) echo $data; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
