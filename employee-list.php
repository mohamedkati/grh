<?php
$pageTitle = "Accueil"; // Définir le titre de la page
include 'includes/header.php';
include 'includes/sidebar.php';
?>


<div class="main-panel">
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-sm-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">List des employés</div>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">First</th>
                                        <th scope="col">Last</th>
                                        <th scope="col">pushed from git</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>1</td>
                                        <td>Mohammed</td>
                                        <td>KATI</td>
                                        <td>@mdo</td>
                                    </tr>

                                    <tr>
                                        <td>1</td>
                                        <td>Mohammed</td>
                                        <td>KATI</td>
                                        <td>@mdo</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include 'includes/footer.php'; ?>
