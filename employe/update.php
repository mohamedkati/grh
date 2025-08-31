<?php
include '../includes/database.php';
$nom = "";
$prenom = "";
$date_naissance = "";
$email = "";
$telephone = "";
$adresse = "";
$date_debut_contrat = "";
$date_fin_contrat = "";
$type_employe = "";
$mot_de_passe = "";
$id_contrat = "";
$id_poste = "";
$data = "";
$id = $_GET['id'] ?? '';
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (!empty($id)) {
        $conn = new PDO("mysql:host=localhost;dbname=$database", "root", "");
        $query = $conn->prepare("SELECT * FROM employe WHERE id = :id");
        $query->execute(['id' => $id]);
        $employe = $query->fetch(PDO::FETCH_ASSOC);
        if ($employe) {
            $nom = $employe['nom'] ?? '';
            $prenom = $employe['prenom'] ?? '';
            $date_naissance = $employe['date_naissance'] ?? '';
            $email = $employe['email'] ?? '';
            $telephone = $employe['telephone'] ?? '';
            $adresse = $employe['adresse'] ?? '';
            $date_debut_contrat = $employe['date_debut_contrat'] ?? '';
            $date_fin_contrat = $employe['date_fin_contrat'] ?? '';
            $type_employe = $employe['type_employe'] ?? '';
            $mot_de_passe = $employe['mot_de_passe'] ?? '';
            $id_contrat = $employe['id_contrat'] ?? '';
            $id_poste = $employe['id_poste'] ?? '';
        } else {
            $data = "<div class='alert alert-danger'>Personne non trouvée.</div>";
        }
    } else {
        $data = "<div class='alert alert-danger'>ID invalide.</div>";
    }
}

function VerifierEmail($email): string
{

    // verificaton de @ si exite ou non
    $position1 = strpos($email, "@");
    if ($position1 == false || $position1 == 0) {
        return "<div class='alert alert-danger'>Format d'email invalide.</div>";
    }

    // verification du doublon d'@
    $countarrobas = strpos($email, "@", $position1 + 1);
    if ($countarrobas != false) {
        return "<div class='alert alert-danger'>@ ne doit pas etre dupliqué .</div>";
    }

    // ve$irification des caractères avant @
    if ($position1 < 3) {
        return "<div class='alert alert-danger'>Format d'email invalide(3 caractères minimumes avant @).</div>";
    }

    // verification du point après @
    $position2 = strpos($email, ".", $position1);
    if ($position2 == false) {
        return "<div class='alert alert-danger'>Format d'email invalide(. doit etre inséré après @).</div>";
    }
    //verification des caractères après @ et avant . 
    if ($position2 - $position1 <= 3) {
        return "<div class='alert alert-danger'>Format d'email invalide(3 caractères minimum après @).</div>";
    }

    // un email valide ne doit pas etre terminé par une point

    $point = str_ends_with($email, ".");
    if ($point === true) {
        return "<div class='alert alert-danger'>un email valide ne doit pas etre terminé par une point.</div>";
    }
    //identification des caractères après dernier . (les caractères après point doivent etre plus ou égale à deux caractères)

    $position3 = substr($email, $position2);
    if (strlen($position3) <= 2) {
        return "<div class='alert alert-danger'>Format d'email invalide(2 caractères minimumes après le point).</div>";
    }

    return "";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // $id = $_GET['id'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $date_naissance = $_POST['date_naissance'] ?? '';
    $email = $_POST['email'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $adresse = $_POST['adresse'] ?? '';
    $date_debut_contrat = $_POST['date_debut_contrat'] ?? '';
    $date_fin_contrat = $_POST['date_fin_contrat'] ?? '';
    $type_employe = $_POST['type_employe'] ?? '';
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';
    $id_contrat = $_POST['id_contrat'] ?? '';
    $id_poste = $_POST['id_poste'] ?? '';

    if (empty($nom) === true) {
        $data = $data . "<div class='alert alert-danger'>Le nom  est requis.</div>";
    }
    if (empty($prenom) === true) {
        $data = $data . "<div class='alert alert-danger'>Le prènom est requis.</div>";
    }
    if (empty($date_naissance) === true) {
        $data = $data . "<div class='alert alert-danger'>La date de naissance est requis.</div>";
    }
    if (empty($email) === true) {
        $data = $data . "<div class='alert alert-danger'>L'email est requis.</div>";
    }
    if (empty($telephone) === true) {
        $data = $data . "<div class='alert alert-danger'>Le Numèro de téléphone est requis.</div>";
    }
    if (empty($date_debut_contrat) === true) {
        $data = $data . "<div class='alert alert-danger'>La date début de contrat est requis.</div>";
    }
    if (empty($date_fin_contrat) === true) {
        $data = $data . "<div class='alert alert-danger'>La date fin de contrat est requis.</div>";
    }
    if (empty($type_employe) === true) {
        $data = $data . "<div class='alert alert-danger'>Le type d'employé  est requis.</div>";
    }
    if (empty($mot_de_passe) === true) {
        $data = $data . "<div class='alert alert-danger'>Le mot de passe est requis.</div>";
    }
    if (empty($id_contrat) === true) {
        $data = $data . "<div class='alert alert-danger'>L'Id contrat est requis.</div>";
    }
    if (empty($id_poste) === true) {
        $data = $data . "<div class='alert alert-danger'>L'Id poste est requis.</div>";
    }
    $emailVerificationError = VerifierEmail($email);
    if (empty($emailVerificationError) == false) {
        $data .= $emailVerificationError;
    }
    $conn = new PDO("mysql:host=localhost;dbname=$database", "root", "");
    if (empty($data)) {
        try {
            $query = $conn->prepare("SELECT email FROM employe WHERE email = :email AND id != :id");
            $query->execute(['email' => $email, "id" => $id]);
            $emails = $query->fetchAll(PDO::FETCH_ASSOC);

            if (count($emails) > 0) {
                $data =  "<div class='alert alert-danger'>L'email existe déjà.</div>";
            }
        } catch (PDOException $e) {
            $data = "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
        }
        $query = $conn->prepare("SELECT telephone FROM employe WHERE telephone = :telephone");
        $query->execute(['telephone' => $telephone]);
        $telephones = $query->fetchAll(PDO::FETCH_ASSOC);
        if (count($telephones) > 0) {
            $data =  "<div class='alert alert-danger'>ce numèro de téléphone existe déjà.</div>";
        }
    }

    if (empty($data)) {
        try {
            $query = $conn->prepare("UPDATE employe set nom=:nom, prenom=:prenom, date_naissance=:date_naissance, email=:email, telephone=:telephone
        , adresse=:adresse, date_debut_contrat=:date_debut_contrat, date_fin_contrat=:date_fin_contrat,type_employe=:type_employe,
        mot_de_passe=:mot_de_passe ,id_contrat=:id_contrat,id_poste=:id_poste where id = :id");
            $query->execute([
                'nom' => $nom,
                'prenom' => $prenom,
                'date_naissance' => $date_naissance,
                'email' => $email,
                'telephone' => $telephone,
                'adresse' => $adresse,
                'date_debut_contrat' => $date_debut_contrat,
                'date_fin_contrat' => $date_fin_contrat,
                'type_employe' => $type_employe,
                'mot_de_passe' => $mot_de_passe,
                'id_contrat' => $id_contrat,
                'id_poste' => $id_poste,
                "id" => $id
            ]);

            header("Location: ../employe/listing.php", true, 301);
            exit();
            $data = "<div class='alert alert-success'>Personne modifiée avec succès.</div>";
        } catch (PDOException $e) {
            $data = "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
        }
    }
}
$conn = new PDO("mysql:host=localhost;dbname=$database", "root", "");
$query = $conn->prepare("SELECT id,nom FROM poste ");
$query->execute();
$postes = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $conn->prepare("SELECT id,nom FROM contrat ");
$query->execute();
$contrats = $query->fetchAll(PDO::FETCH_ASSOC);
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
                                <div class="card-title">Modifié Employé</div>
                            </div>
                            <div class="card-body">

                                <div class="form-group form-inline">
                                    <label for="nom" class="col-md-3 col-form-label">Nom </label>
                                    <input type="text" value="<?php echo $nom ?>" class="form-control input-full" id="nom" name="nom">
                                </div>
                                <div class="form-group form-inline">
                                    <label for="prenom" class="col-md-3 col-form-label">Prenom</label>
                                    <input type="text" value="<?php echo $prenom ?>" class="form-control input-full" id="prenom" name="prenom">
                                </div>
                                <div class="form-group form-inline">
                                    <label for="date_naissance" class="col-md-3 col-form-label">Date Naissance</label>
                                    <input type="date" value="<?php echo $date_naissance ?>" class="form-control input-full" id="date_naissance" name="date_naissance">
                                </div>
                                <div class="form-group form-inline">
                                    <label for="email" class="col-md-3 col-form-label">Email</label>
                                    <input type="text" value="<?php echo $email ?>" class="form-control input-full" id="email" name="email">
                                </div>
                                <div class="form-group form-inline">
                                    <label for="telephone" class="col-md-3 col-form-label">Téléphone</label>
                                    <input type="text" value="<?php echo $telephone ?>"
                                        class="form-control input-full" id="telephone" name="telephone">
                                </div>
                                <div class="form-group form-inline">
                                    <label for="adresse" class="col-md-3 col-form-label">Adresse</label>
                                    <input type="text" value="<?php echo $adresse ?>" class="form-control input-full" id="adresse" name="adresse">
                                </div>
                                <div class="form-group form-inline">
                                    <label for="date_debut_contrat" class="col-md-3 col-form-label">Date début de contrat</label>
                                    <input type="date" value="<?php echo $date_debut_contrat ?>" class="form-control input-full" id="date_debut_contrat" name="date_debut_contrat">
                                </div>
                                <div class="form-group form-inline">
                                    <label for="date_fin_contrat" class="col-md-3 col-form-label">Date fin de contrat</label>
                                    <input type="date" value="<?php echo $date_fin_contrat ?>" class="form-control input-full" id="date_fin_contrat" name="date_fin_contrat">
                                </div>
                                <div class="form-group form-inline">
                                    <label for="type_employe" class="col-md-3 col-form-label">Entrer le type d'Employé</label>
                                    <input type="text" value="<?php echo $type_employe ?>" class="form-control input-full" id="type_employe" name="type_employe">
                                </div>
                                <div class="form-group form-inline">
                                    <label for="mot_de_passe" class="col-md-3 col-form-label">Entrer le mot de passe</label>
                                    <input type="password" value="<?php echo $mot_de_passe ?>" class="form-control input-full" id="mot_de_passe" name="mot_de_passe">
                                </div>
                                <div class="form-group form-inline">
                                    <label for="id_poste" class="col-md-3 col-form-label">Entrer l'Id Poste</label>
                                    <select class="form-select" name="id_poste" value="<?= $id_poste ?>" name="id_poste" id="exampleFormControlSelect1">
                                        <option value="">Sélectionner</option>
                                        <?php foreach ($postes as $index => $d): ?>
                                            <option value="<?= $d['id']?>" <?= $d['id']===$id_poste ?  'selected':''?>> <?= $d['nom'] ?> </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group form-inline">
                                    <label for="id_contrat" class="col-md-3 col-form-label">Entrer l'Id contrat</label>
                                    <select class="form-select" name="id_contrat" value="<?= $id_contrat ?>" id="exampleFormControlSelect1">
                                        <option value="">Sélectionner</option>
                                        <?php foreach ($contrats as $index => $c): ?>
                                            <option value="<?= $d['id']?>" <?= $c['id']===$id_contrat ?  'selected':''?>> <?= $c['nom'] ?> </option>
                                        <?php endforeach; ?>
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
                                    Modfier
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