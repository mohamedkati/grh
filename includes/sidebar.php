<!-- Sidebar -->
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

<style>
.sidebar {
    width: 220px;
    height: 100vh;
    background: #2c3e50;
    padding: 20px 0;
    position: fixed;
    top: 0;
    left: 0;
}
.sidebar h2 {
    color: #ecf0f1;
    text-align: left;   
    margin: 0 0 20px 20px;
    font-size: 20px;
    border-bottom: 1px solid #7f8c8d;
    padding-bottom: 10px;
}
.sidebar ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.sidebar ul li {
    margin: 15px 0;
}
.sidebar ul li a {
    color: #ecf0f1;
    text-decoration: none;
    font-size: 16px;
    display: block;
    padding: 10px 20px;
    transition: 0.3s;
}
.sidebar ul li a:hover {
    background: #34495e;
    border-radius: 5px;
}
</style>
