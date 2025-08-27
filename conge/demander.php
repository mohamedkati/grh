<?php
// connexion bdd
$conn = new PDO("mysql:host=localhost;dbname=entreprise_grh;charset=utf8", "root", "");

// traiter formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employe_id = $_POST['employe_id'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];

    $sql = "INSERT INTO conge (employe_id, date_debut, date_fin, statut) 
            VALUES ('$employe_id', '$date_debut', '$date_fin', 'En attente')";
    $conn->exec($sql);

    echo "✅ Demande de congé ajoutée avec succès !";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demander un congé</title>
</head>
<body>
    <h2>Demander un congé</h2>
    <form method="POST">
        <label>Employé :</label>
        <select name="employe_id" required>
            <?php
            $sql = "SELECT id, nom FROM employe";
            $result = $conn->query($sql);
            foreach ($result as $row) {
                echo "<option value='".$row['id']."'>".$row['nom']."</option>";
            }
            ?>
        </select>
        <br><br>

        <label>Date début :</label>
        <input type="date" name="date_debut" required>
        <br><br>

        <label>Date fin :</label>
        <input type="date" name="date_fin" required>
        <br><br>

        <button type="submit">Demander</button>
    </form>
</body>
</html>
