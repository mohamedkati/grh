<?php
$conn = new PDO("mysql:host=localhost;dbname=gestion_rh;charset=utf8", "root", "");

// récupérer la valeur de recherche
$search = $_GET['search'] ?? '';

$sql = "
    SELECT a.id, e.nom AS employe, e.poste, d.nom_departement, a.date_debut, a.jours
    FROM absence a
    JOIN employe e ON a.employe_id = e.id
    JOIN departement d ON e.departement_id = d.id
";

if (!empty($search)) {
    $sql .= " WHERE e.nom LIKE :search OR e.poste LIKE :search OR d.nom_departement LIKE :search";
}

$stmt = $conn->prepare($sql);

if (!empty($search)) {
    $stmt->execute(['search' => "%$search%"]);
} else {
    $stmt->execute();
}

$absences = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Liste des Absences</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body class="container mt-4">

    <h2>Liste des Absences</h2>

    <!-- Formulaire de recherche -->
    <form method="get" class="row mb-3">
        <div class="col-md-8">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control" placeholder="Rechercher par employé, poste ou département">
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Rechercher</button>
            <a href="listing.php" class="btn btn-secondary">Réinitialiser</a>
        </div>
    </form>

    <!-- Tableau des absences -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Employé</th>
                <th>Poste</th>
                <th>Département</th>
                <th>Date début</th>
                <th>Nombre de jours</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($absences) > 0): ?>
                <?php foreach ($absences as $abs): ?>
                    <tr>
                        <td><?= $abs['id'] ?></td>
                        <td><?= htmlspecialchars($abs['employe']) ?></td>
                        <td><?= htmlspecialchars($abs['poste']) ?></td>
                        <td><?= htmlspecialchars($abs['nom_departement']) ?></td>
                        <td><?= $abs['date_debut'] ?></td>
                        <td><?= $abs['jours'] ?></td>
                        <td>
                            <a href="update.php?id=<?= $abs['id'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                            <a href="delete.php?id=<?= $abs['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette absence ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7" class="text-center">Aucune absence trouvée.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="create.php" class="btn btn-success">Ajouter une Absence</a>

</body>
</html>
