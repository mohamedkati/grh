<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Application GRH</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
    body { height: 100vh; }

    /* 🌟 Splash Screen */
    .splash {
      background: #2c3e50;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      font-size: 50px;
      font-weight: bold;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      z-index: 1000;
      animation: fadeOut 0.5s ease forwards;
      animation-delay: 1s; /* GRH 1s seulement */
    }
    @keyframes fadeOut { to { opacity: 0; visibility: hidden; } }

    /* 🌟 Login Page */
    .login-container {
      display: none;
      height: 100vh;
      align-items: center;
      justify-content: center;
      background: #ecf0f1;
    }
    .login-box {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
      text-align: center;
      width: 300px;
    }
    .login-box h2 { margin-bottom: 20px; }
    .login-box input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .login-box button {
      width: 100%;
      padding: 10px;
      background: #2c3e50;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .login-box button:hover { background: #34495e; }

    /* 🌟 Sidebar */
    .app { display: none; }
    .sidebar {
      width: 220px;
      height: 100vh;
      background: #2c3e50;
      padding: 20px 0;
      position: fixed;
      top: 0; left: 0;
    }
    .sidebar h2 {
      color: #ecf0f1;
      text-align: left;
      margin: 0 0 20px 20px;
      font-size: 20px;
      border-bottom: 1px solid #7f8c8d;
      padding-bottom: 10px;
    }
    .sidebar ul { list-style: none; padding: 0; margin: 0; }
    .sidebar ul li { margin: 15px 0; }
    .sidebar ul li a {
      color: #ecf0f1;
      text-decoration: none;
      font-size: 16px;
      display: block;
      padding: 10px 20px;
      transition: 0.3s;
    }
    .sidebar ul li a:hover, .sidebar ul li a.active {
      background: #34495e;
      border-radius: 5px;
    }

    /* 🌟 Content centré */
    .content {
      margin-left: 400px; /* espace pour sidebar */
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .welcome-box {
      background: #2c3e50;
      color: #fff;
      padding: 30px 40px;
      border-radius: 15px;
      text-align: center;
      box-shadow: 0 0 15px rgba(0,0,0,0.3);
    }
    .welcome-box h1 { font-size: 24px; margin-bottom: 10px; }
    .welcome-box p { font-size: 18px; }

    @media screen and (max-width: 768px) {
      .sidebar { width: 60px; }
      .sidebar ul li a { font-size: 0; padding: 10px; }
      .sidebar h2 { font-size: 0; }
      .content { margin-left: 70px; }
      .welcome-box { padding: 20px; font-size: 14px; }
      .welcome-box h1 { font-size: 18px; }
      .welcome-box p { font-size: 14px; }
    }
  </style>
</head>
<body>

  <!-- Splash Screen -->
  <div class="splash">GRH</div>

  <!-- Login Page -->
  <div class="login-container" id="loginPage">
    <div class="login-box">
      <h2>Connexion</h2>
      <input type="text" id="code" placeholder="Entrez le code" required>
      <button onclick="login()">Se connecter</button>
    </div>
  </div>

  <!-- Application -->
  <div class="app" id="appPage">
    <div class="sidebar">
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

    <div class="content">
      <div class="welcome-box">
        <h1>Bienvenue dans l'application GRH</h1>
        <p>Sélectionnez une option depuis le menu à gauche.</p>
      </div>
    </div>
  </div>

  <script>
    // Splash screen 1 seconde -> login
    setTimeout(() => {
      document.querySelector(".splash").style.display = "none";
      document.getElementById("loginPage").style.display = "flex";
    }, 1000);

    // Vérification code
    function login() {
      const code = document.getElementById("code").value;
      if (code === "1234") {
        document.getElementById("loginPage").style.display = "none";
        document.getElementById("appPage").style.display = "flex";
      } else {
        alert("Code incorrect !");
      }
    }
  </script>

</body>
</html>
