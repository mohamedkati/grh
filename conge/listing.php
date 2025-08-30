<?php
include '../includes/database.php';

try {
    $conn = new PDO("mysql:host=localhost;dbname=$database;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Gestion des actions Accept / Reject
if (isset($_GET['action'], $_GET['id'])) {
    $id = (int)$_GET['id'];
    if ($_GET['action'] === 'accept') {
        $stmt = $conn->prepare("UPDATE conge SET statut = 'accepté' WHERE id = :id");
        $stmt->execute([':id' => $id]);
    } elseif ($_GET['action'] === 'reject') {
        $stmt = $conn->prepare("UPDATE conge SET statut = 'rejeté' WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
    header("Location: listing.php");
    exit();
}

// Récupérer toutes les demandes de congé avec filtres poste et departement
try {
    $sql = "
        SELECT c.id, e.nom AS nom_employe, e.prenom, p.nom AS nom_poste, d.nom AS nom_departement,
               c.date_debut, c.date_fin, c.statut
        FROM conge c
        JOIN employe e ON c.id_employe = e.id
        JOIN poste p ON e.id_poste = p.id
        JOIN departement d ON p.id_departement = d.id
        WHERE 1=1
    ";

    $params = [];

    if (!empty($_GET['poste'])) {
        $sql .= " AND p.nom LIKE :poste";
        $params[':poste'] = "%" . $_GET['poste'] . "%";
    }

    if (!empty($_GET['departement'])) {
        $sql .= " AND d.nom LIKE :departement";
        $params[':departement'] = "%" . $_GET['departement'] . "%";
    }

    $sql .= " ORDER BY c.date_debut DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $conges = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    die("Erreur lors de la récupération : " . $e->getMessage());
}
?>

<?php
$pageTitle = "Liste des Congés"; 
$prefix = "../";
include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="main-panel">
    <div class="container">
        <div class="page-inner">

            <!-- Formulaire de recherche -->
            <form method="get" class="mb-3">
                <div class="row g-2">
                    <div class="col-md-6">
                        <input type="text" name="poste" class="form-control" placeholder="Poste" value="<?= htmlspecialchars($_GET['poste'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="departement" class="form-control" placeholder="Département" value="<?= htmlspecialchars($_GET['departement'] ?? '') ?>">
                    </div>
                </div>
                <div class="mt-2">
                    <button type="submit" class="btn btn-info">Rechercher</button>
                    <a href="listing.php" class="btn btn-secondary">Réinitialiser</a>
                </div>
            </form>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Liste des Congés</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th class="d-none d-md-table-cell">Prénom</th>
                                    <th>Poste</th>
                                    <th class="d-none d-md-table-cell">Département</th>
                                    <th class="d-none d-md-table-cell">Date Début</th>
                                    <th class="d-none d-md-table-cell">Date Fin</th>
                                    <th>Statut</th>
                                    <th style="min-width:150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($conges)): ?>
                                    <?php foreach($conges as $c): ?>
                                        <tr>
                                            <td><?= $c['id']; ?></td>
                                            <td><?= htmlspecialchars($c['nom_employe']); ?></td>
                                            <td class="d-none d-md-table-cell"><?= htmlspecialchars($c['prenom']); ?></td>
                                            <td><?= htmlspecialchars($c['nom_poste']); ?></td>
                                            <td class="d-none d-md-table-cell"><?= htmlspecialchars($c['nom_departement']); ?></td>
                                            <td class="d-none d-md-table-cell"><?= htmlspecialchars($c['date_debut']); ?></td>
                                            <td class="d-none d-md-table-cell"><?= htmlspecialchars($c['date_fin']); ?></td>
                                            <td>
                                                <?php 
                                                    switch($c['statut']) {
                                                        case 'en cours':
                                                            echo '<span class="badge bg-warning">En cours</span>';
                                                            break;
                                                        case 'accepté':
                                                            echo '<span class="badge bg-success">Accepté</span>';
                                                            break;
                                                        case 'rejeté':
                                                            echo '<span class="badge bg-danger">Rejeté</span>';
                                                            break;
                                                        default:
                                                            echo '<span class="badge bg-secondary">Inconnu</span>';
                                                    }
                                                ?>
                                            </td>
                                            <td style="min-width:150px; text-align:center;">
                                                <div class="d-flex flex-column gap-1">
                                                    <?php if($c['statut'] === 'en cours'): ?>
                                                        <a href="listing.php?action=accept&id=<?= $c['id']; ?>" class="btn btn-success btn-sm">Accept</a>
                                                        <a href="listing.php?action=reject&id=<?= $c['id']; ?>" class="btn btn-danger btn-sm">Reject</a>
                                                    <?php else: ?>
                                                        <span class="text-muted">--</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center">Aucune demande trouvée</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div> <!-- /table-responsive -->
                </div>
            </div>

        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
