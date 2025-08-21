<?php
include '../includes/database.php';
$data = "";
$nom_poste = "";
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $nom_poste = $_POST['nom_poste'] ?? "";
    $id_departement =$_POST['id_departement'] ?? "";
    
    
    if (empty($nom_poste) === true) {
        $data = $data . "<div class='alert alert-danger'>Le nom de poste est requis.</div>";
    }
    if (empty($id_departement) === true) {
        $data = $data . "<div class='alert alert-danger'>Le departement est requis.</div>";
    }

     $conn = new PDO("mysql:host=localhost;dbname=$database", "root", "");
       if (empty($data)) {
        $query = $conn->prepare("SELECT * FROM poste WHERE nom = :nom_poste");
        $query->execute(['nom_poste' => $nom_poste]);
        $postes = $query->fetchAll(PDO::FETCH_ASSOC);

        if (count($postes) > 0) {
            $data =  "<div class='alert alert-danger'>Ce poste existe déjà.</div>";
        }
    }
    if (empty($data)) {

        $query = $conn->prepare("INSERT INTO poste (nom,id_departement)
         VALUES (:nom_poste,:id_departement)");
        $query->execute([
            'nom_poste' => $nom_poste,
            'id_departement'=> $id_departement
        ]);

        header("Location: ../poste/listing.php", true, 301);
        exit();
    }
}

$conn = new PDO("mysql:host=localhost;dbname=$database", "root", "");
    $query = $conn->prepare("SELECT id,nom FROM departement "); 
    $query->execute();
    $departements = $query->fetchAll(PDO::FETCH_ASSOC);
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
                                <div class="card-title">Create Poste</div>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="poste">Nom de poste</label>
                                    <input type="text" value="<?= $nom_poste?>" class="form-control" id="nom_poste" name="nom_poste">
                                </div>
                                <div class="form-group">
                                   <label for="exampleFormControlSelect1">Choisir le département</label>
                                   <select class="form-select" name="id_departement" value="<?= $id_departement?>" id="exampleFormControlSelect1">
                                             <option  value="">Sélectionner</option>                             
                                          <?php foreach($departements as $index => $d): ?>
                                             <option  value=<?=$d['id']?>> <?= $d['nom']?> </option>
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
                                    Ajouter
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