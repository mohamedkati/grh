<?php

$data = "";
$fullName = "";
$ville = "";
$email = "";
$dateNaissance = "";
$adresse = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullName = $_POST['fullName'] ?? '';
    $ville = $_POST['ville'] ?? '';
    $email = $_POST['email'] ?? '';
    $dateNaissance = $_POST['dateNaissance'] ?? '';
    $adresse = $_POST['adresse'] ?? '';

    if (empty($fullName) === true) {
        $data = $data . "<div class='alert alert-danger'>Le nom complet est requis.</div>";
    }
    if (empty($ville) === true) {
        $data = $data . "<div class='alert alert-danger'>La ville est requis.</div>";
    }
    if (empty($email) === true) {
        $data = $data . "<div class='alert alert-danger'>L'email est requis.</div>";
    }
    if (empty($dateNaissance) === true) {
        $data = $data . "<div class='alert alert-danger'>La date de naissance est requis.</div>";
    }
    $conn = new PDO("mysql:host=localhost;dbname=testdb", "root", "");
    if (empty($data)) {
        $query = $conn->prepare("SELECT email FROM personne WHERE email = :email");
        $query->execute(['email' => $email]);
        $emails = $query->fetchAll(PDO::FETCH_ASSOC);

        if (count($emails) > 0) {
            $data =  "<div class='alert alert-danger'>L'email existe déjà.</div>";
        }
    }

    if (empty($data)) {

        $query = $conn->prepare("INSERT INTO personne (fullname, ville, email, dateNaissance, adresse)
         VALUES (:fullName, :ville,:email, :dateNaissance, :adresse)");
        $query->execute([
            'fullName' => $fullName,
            'ville' => $ville,
            'email' => $email,
            'dateNaissance' => $dateNaissance,
            'adresse' => $adresse
        ]);

        header("Location: ../personne/listing.php", true, 301);
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
                <div class="col-md-6">
                    <form action="" method="post">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Create Personne</div>
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
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Les erreurs</div>
                        </div>
                        <div class="card-body">
                            <?php
                            if (empty($data) === false) {
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

<script>
    $('button[type="button"]').click(function() {
        $('input[type="text"], input[type="date"]').val('');
    });
</script>