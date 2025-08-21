<?php

$errors = "";
$nom_poste = "";
$id_poste = $_GET['id_poste'] ?? '';
    $conn = new PDO("mysql:host=localhost;dbname=gestion_rh", "root", "");
    $query = $conn->prepare("SELECT id_departement,nom_departement FROM departement "); 
    $query->execute();
    $departements = $query->fetchAll(PDO::FETCH_ASSOC);
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (!empty($id_poste)) {
        $conn = new PDO("mysql:host=localhost;dbname=gestion_rh", "root", "");
        $query = $conn->prepare("SELECT nom_poste,id_departement FROM poste WHERE id_poste = :id_poste");
        $query->execute(['id_poste' => $id_poste]);
        $postes = $query->fetch(PDO::FETCH_ASSOC);
        if (!empty($postes)) {
            $nom_poste = $postes['nom_poste'];
            $id_departement =$postes['id_departement'];
        } else {
            $errors = "<div class='alert alert-danger'>poste non trouvée.</div>";
        }
    } else {
        $errors = "<div class='alert alert-danger'>ID invalide.</div>";
    }
} 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // $id = $_GET['id'] ?? '';
    $nom_poste = $_POST['nom_poste'] ?? '';
   $id_departement = $_POST['id_departement'] ?? '';


    if (empty($nom_poste) === true) {
        $errors = $errors . "<div class='alert alert-danger'>Le nom de poste est requis.</div>";
    }
    $conn = new PDO("mysql:host=localhost;dbname=gestion_rh", "root", "");
    if (empty($errors)) {
        try {
            $query = $conn->prepare("SELECT nom_poste FROM poste WHERE nom_poste = :nom_poste AND id_poste != :id_poste");
            $query->execute(['nom_poste' => $nom_poste, "id_poste" => $id_poste]);
            $postes = $query->fetchAll(PDO::FETCH_ASSOC);

            if (count($postes) > 0) {
                $errors =  "<div class='alert alert-danger'>Le poste existe déjà.</div>";
            }
        } catch (PDOException $e) {
            $errors = "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
        }
    }
    if (empty($errors)) {
        try {
            $query = $conn->prepare("UPDATE poste set nom_poste=:nom_poste, id_departement=:id_departement where id_poste = :id_poste");
            $query->execute([
                'nom_poste' => $nom_poste,
                'id_departement' => $id_departement,
                "id_poste" => $id_poste
            ]);

            header("Location: ../poste/listing.php", true, 301);
            exit();
            $id_poste = $id_departement  = "";
            $errors = "<div class='alert alert-success'>poste modifiée avec succès.</div>";
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
                <div class="col-md-6">
                    <form action="" method="post">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Modifier Poste</div>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="poste">Nom de poste</label>
                                    <input type="text" value="<?php echo $nom_poste ?>" class="form-control" id="nom_poste" name="nom_poste">
                                </div>
                                <div class="form-group">
                                   <label for="exampleFormControlSelect1">Choisir le département</label>
                                   <select class="form-select" value="<?= $id_departement ?>" name="id_departement" id="exampleFormControlSelect1">
                                         <option  value="">
                                         </option>                             
                                          <?php foreach($departements as $index => $d): ?>
                                             <option  <?= $d['id_departement']===$id_departement ?  'selected':''?> value=<?=$d['id_departement']?>> <?= $d['nom_departement']?> </option>
                                            <?php endforeach ;?>                       
                                   </select>
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
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Les messages d'erreurs</div>
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