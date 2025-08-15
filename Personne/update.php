<?php


$errors = "";
$fullName = "";
$ville = "";
$email = "";
$dateNaissance = "";
$adresse = "";
$id = $_GET['id'] ?? '';
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (!empty($id)) {
        $conn = new PDO("mysql:host=localhost;dbname=testdb", "root", "");
        $query = $conn->prepare("SELECT * FROM personne WHERE id = :id");
        $query->execute(['id' => $id]);
        $personne = $query->fetch(PDO::FETCH_ASSOC);
        if ($personne) {
            $fullName = $personne['FullName'];
            $ville = $personne['Ville'];
            $email = $personne['Email'];
            $dateNaissance = $personne['DateNaissance'];
            $adresse = $personne['Adresse'];
        } else {
            $errors = "<div class='alert alert-danger'>Personne non trouvée.</div>";
        }
    } else {
        $errors = "<div class='alert alert-danger'>ID invalide.</div>";
    }
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // $id = $_GET['id'] ?? '';
    $fullName = $_POST['fullName'] ?? '';
    $ville = $_POST['ville'] ?? '';
    $email = $_POST['email'] ?? '';
    $dateNaissance = $_POST['dateNaissance'] ?? '';
    $adresse = $_POST['adresse'] ?? '';

    if (empty($fullName) === true) {
        $errors = $errors . "<div class='alert alert-danger'>Le nom complet est requis.</div>";
    }
    if (empty($ville) === true) {
        $errors = $errors . "<div class='alert alert-danger'>La ville est requis.</div>";
    }
    if (empty($email) === true) {
        $errors = $errors . "<div class='alert alert-danger'>L'email est requis.</div>";
    }
    if (empty($dateNaissance) === true) {
        $errors = $errors . "<div class='alert alert-danger'>La date de naissance est requis.</div>";
    }
    $conn = new PDO("mysql:host=localhost;dbname=testdb", "root", "");
    if (empty($errors)) {
        try {
            $query = $conn->prepare("SELECT email FROM personne WHERE email = :email AND id != :id");
            $query->execute(['email' => $email, "id" => $id]);
            $emails = $query->fetchAll(PDO::FETCH_ASSOC);

            if (count($emails) > 0) {
                $errors =  "<div class='alert alert-danger'>L'email existe déjà.</div>";
            }
        } catch (PDOException $e) {
            $errors = "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
        }
    }

    if (empty($errors)) {
        try {
            $query = $conn->prepare("UPDATE PERSONNE set fullname=:fullName, ville=:ville, email=:email, dateNaissance=:dateNaissance
        , adresse=:adresse where id = :id");
            $query->execute([
                'fullName' => $fullName,
                'ville' => $ville,
                'email' => $email,
                'dateNaissance' => $dateNaissance,
                'adresse' => $adresse,
                "id" => $id
            ]);

            header("Location: ../personne/listing.php", true, 301);
            exit();
            $fullName = $ville = $email = $dateNaissance = $adresse = "";
            $errors = "<div class='alert alert-success'>Personne modifiée avec succès.</div>";
        } catch (PDOException $e) {
            $errors = "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
        }
    }
}

?>

<?php
$pageTitle = "Accueil"; // Définir le titre de la page
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
                                <div class="card-title">Modification Personne</div>
                            </div>
                            <div class="card-body">

                                <div class="form-group form-inline">
                                    <label for="fullName" class="col-md-3 col-form-label">Full Name</label>
                                    <input type="text" value="<?php echo $fullName ?>" class="form-control input-full" id="fullName" name="fullName">
                                </div>
                                <div class="form-group form-inline">
                                    <label for="ville" class="col-md-3 col-form-label">Ville</label>
                                    <input type="text" value="<?php echo $ville ?>" class="form-control input-full" id="ville" name="ville">
                                </div>
                                <div class="form-group form-inline">
                                    <label for="email" class="col-md-3 col-form-label">Email</label>
                                    <input type="text" value="<?php echo $email ?>" class="form-control input-full" id="email" name="email">
                                </div>
                                <div class="form-group form-inline">
                                    <label for="dateNaissance" class="col-md-3 col-form-label">Date Naissance</label>
                                    <input type="date" value="<?php echo $dateNaissance ?>" class="form-control input-full" id="dateNaissance" name="dateNaissance">
                                </div>
                                <div class="form-group form-inline">
                                    <label for="adresse" class="col-md-3 col-form-label">Adresse</label>
                                    <input type="text" value="<?php echo $adresse ?>" class="form-control input-full" id="adresse" name="adresse">
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
                                <button type="button" class="btn btn-black" onclick="<?php $fullName = ""; ?>">
                                    <span class="btn-label">
                                        <i class="fa fa-archive"></i>
                                    </span>
                                    Vider
                                </button>
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
                            if (empty($errors) === false) {
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