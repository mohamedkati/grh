<?php
session_start();

session_destroy();  
session_start();    

include '../includes/database.php'; // $database = "gestion_rh"

$showApp = false; 

// ===== Vérification login =====
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $mot_de_passe = trim($_POST["mot_de_passe"]);

    try {
        $conn = new PDO("mysql:host=localhost;dbname=$database;charset=utf8", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM employe WHERE email = :email AND mot_de_passe = :mot_de_passe");
        $stmt->execute([ ":email"=>$email, ":mot_de_passe"=>$mot_de_passe ]);
        $employe = $stmt->fetch(PDO::FETCH_ASSOC);

        if($employe){
            $_SESSION["logged"] = true;
            $_SESSION["user"] = $employe["nom"];
            $showApp = true; 
        } else {
            $error = "❌ Email ou mot de passe incorrect !";
        }

    } catch(PDOException $e){
        $error = "Erreur DB : ".$e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Application GRH</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:Arial,sans-serif; }
html, body { height:100%; }

/* Splash screen */
.splash { position: fixed; top:0; left:0; width:100%; height:100%; background:#2c3e50; color:white; display:flex; align-items:center; justify-content:center; font-size:50px; font-weight:bold; z-index:1000; }

/* Login */
.login-container { display:none; height:100%; justify-content:center; align-items:center; background:#ecf0f1; }
.login-box { background:white; padding:30px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.2); text-align:center; width:350px; }
.login-box h2 { margin-bottom:20px; }
.login-box input { width:100%; padding:10px; margin:10px 0; border:1px solid #ccc; border-radius:5px; }
.login-box button { width:100%; padding:10px; background:#2c3e50; color:white; border:none; border-radius:5px; cursor:pointer; }
.login-box button:hover { background:#34495e; }
.error { color:red; font-size:14px; }

/* Sidebar */
.sidebar { width:220px; height:100vh; background:#2c3e50; padding:20px 0; position:fixed; top:0; left:0; display:none; }
.sidebar h2 { color:#ecf0f1; text-align:left; margin:0 0 20px 20px; font-size:20px; border-bottom:1px solid #7f8c8d; padding-bottom:10px; }
.sidebar ul { list-style:none; padding:0; margin:0; }
.sidebar ul li { margin:15px 0; }
.sidebar ul li a { color:#ecf0f1; text-decoration:none; font-size:16px; display:block; padding:10px 20px; transition:0.3s; cursor:pointer; }
.sidebar ul li a:hover, .sidebar ul li a.active { background:#34495e; border-radius:5px; }
.logout-btn { display:inline-block; margin-top:15px; padding:8px 15px; background:#c0392b; color:white; text-decoration:none; border-radius:5px; }
.logout-btn:hover { background:#e74c3c; }

/* Content */
.content { margin-left:220px; height:100vh; padding:20px; }
.welcome-box { text-align:center; background:#2c3e50; padding:40px 60px; border-radius:15px; color:#fff; box-shadow:0 0 15px rgba(0,0,0,0.3); }
.welcome-box h1 { font-size:32px; margin-bottom:15px; }
.welcome-box p { font-size:18px; }
.dynamic-content { margin-top:20px; }
</style>
</head>
<body>

<!-- Splash Screen -->
<div class="splash" id="splash">GRH</div>

<?php if(!$showApp): ?>
<!-- Login Page -->
<div class="login-container" id="loginContainer">
    <div class="login-box">
        <h2>Connexion</h2>
        <?php if(!empty($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST" action="">
            <input type="email" name="email" placeholder="Entrez votre email" required>
            <input type="password" name="mot_de_passe" placeholder="Entrez votre mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
    </div>
</div>
<?php else: ?>
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <h2>📌 Menu</h2>
    <ul>
        <li><a href="../employe/listing.php">👤 Employés</a></li>
        <li><a href="../poste/listing.php">📌 Postes</a></li>
        <li><a href="../departement/listing.php">🏢 Départements</a></li>
        <li><a href="../contrat/listing.php">📑 Contrats</a></li>
        <li><a href="../conge/listing.php">📅 Congés</a></li>
        <li><a href="../absence/listing.php">⏰ Absences</a></li>
    </ul>
</div>

<!-- Content -->
<div class="content">
    <div class="welcome-box">
        <h1>Bienvenue <?php echo $_SESSION["user"]; ?> 👋</h1>
        <p>Sélectionnez une option depuis le menu à gauche.</p>
        <div class="dynamic-content" id="dynamicContent"></div>
    </div>
</div>
<?php endif; ?>

<script>
// ⏳ Splash screen 1 seconde
window.addEventListener("load", () => {
    setTimeout(() => {
        document.getElementById("splash").style.display = "none";
        const loginContainer = document.getElementById("loginContainer");
        const sidebar = document.getElementById("sidebar");
        if(loginContainer) loginContainer.style.display = "flex";
        if(sidebar) sidebar.style.display = "block";
    }, 1000);
});
</script>

</body>
</html>
