<?php
include '../includes/database.php';

// Connexion à la base de données
$cnx = new PDO("mysql:host=localhost;dbname=$database;charset=utf8", "root", "");
$cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupérer les critères de recherche
$employe = $_GET['employe'] ?? '';
$departement = $_GET['departement'] ?? '';
$poste = $_GET['poste'] ?? '';

// Requête pour récupérer les absences avec jointures correctes
$sql = "
    SELECT 
        a.id_absence, 
        e.nom AS employe, 
        p.nom AS poste, 
        d.nom AS nom_departement, 
        a.date_absence, 
        a.motif
    FROM absence a
    JOIN employe e ON a.id_employe = e.id
    JOIN poste p ON e.id_poste = p.id
    JOIN departement d ON p.id_departement = d.id
    WHERE e.nom LIKE :employe
    AND p.nom LIKE :poste
    AND d.nom LIKE :departement
    ORDER BY a.date_absence DESC
";

$stmt = $cnx->prepare($sql);
$stmt->execute([
    ':employe' => "%$employe%",
    ':poste' => "%$poste%",
    ':departement' => "%$departement%"
]);

$absences = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
$pageTitle = "Listing des Absences";
$prefix = "../";
include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="main-panel">
    <div class="container">
        <div class="page-inner">
            <h4 class="mb-3">Liste des Absences</h4>

            <!-- FORMULAIRE DE RECHERCHE -->
            <form method="get" class="form-inline mb-3">
                <input type="text" name="employe" placeholder="Nom Employé" value="<?= htmlspecialchars($employe) ?>" class="form-control mr-2">
                <input type="text" name="poste" placeholder="Poste" value="<?= htmlspecialchars($poste) ?>" class="form-control mr-2">
                <input type="text" name="departement" placeholder="Département" value="<?= htmlspecialchars($departement) ?>" class="form-control mr-2">
                <button type="submit" class="btn btn-primary">Rechercher</button>
                <a href="listing.php" class="btn btn-secondary ml-2">Réinitialiser</a>
            </form>

            <!-- TABLEAU DES ABSENCES -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Employé</th>
                        <th>Poste</th>
                        <th>Département</th>
                        <th>Date Absence</th>
                        <th>Motif</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($absences)): ?>
                        <?php foreach ($absences as $a): ?>
                            <tr>
                                <td><?= $a['id_absence'] ?></td>
                                <td><?= htmlspecialchars($a['employe']) ?></td>
                                <td><?= htmlspecialchars($a['poste']) ?></td>
                                <td><?= htmlspecialchars($a['nom_departement']) ?></td>
                                <td><?= htmlspecialchars($a['date_absence']) ?></td>
                                <td><?= htmlspecialchars($a['motif']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Aucune absence trouvée</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
