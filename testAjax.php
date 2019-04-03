<?php
	include "./common/database.php";
	include "./common/StandardHTMLForm.php";
	include "./common/ListFunctions.php";

	$database = new Database("library");
	$adherents = convertPDOToArray($database->createCustomSelectQuery("adherent", null, array("id_adherent", "nom_adherent", "prenom_adherent")));
	$oeuvres = convertPDOToArray($database->createCustomSelectQuery("oeuvre", null, array("id_oeuvre", "titre")));
	$authors = convertPDOToArray($database->createCustomSelectQuery("auteur", null, array("id_auteur", "nom_auteur", "prenom_auteur")));
	$editors = convertPDOToArray($database->createCustomSelectQuery("editeur", null, array("id_editeur", "nom_editeur")));
 ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Ajax test</title>

		<style type="text/css" src="testAjax.css"></style>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Fin bootstrap core CSS -->

        <!-- Custom styles for this template -->
        <link href="css/heroic-features.css" rel="stylesheet">
        <!-- Fin custom styles for this template -->

	</head>
	<body>

        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-info fixed-top">
            <div class="container">
                <div class="text-left">
                    <a class="navbar-brand" href="#">Les Bibliophiles</a>
                    <img src="book.png" class="img-fluid rounded" alt="Responsive image" style="width:5%">
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link text-secondary" data-section="accueil" href="javascript:void(0)">Accueil
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-primary" data-section="adherent" href="javascript:void(0)">Adhérent</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-warning" data-section="auteur" href="javascript:void(0)">Auteur</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" data-section="theme" href="javascript:void(0)">Thème</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Fin navigation -->

        <!-- Page Content -->
        <div class="container">
            <!-- Page Features -->
            <div class="row" id="accueil">
                <div class="col-lg-12">
                    <h1 class="searchTitle text-center m-5 text-secondary">Bienvenue sur les site des bibliophiles !!!</h1>
                </div>
                <div class="col-lg-12 text-center">
                    <img src="biblio.png" class="img-fluid rounded" alt="Responsive image" style="width:70%">
                </div>
            </div>

            <div class="row" id="adherent">
                <div class="col-lg-12">
                    <h1 class="searchTitle text-center m-5 text-primary">Recherche par Adhérent</h1>
                </div>
                <div class="col-lg-6 col-md-6 mb-4 text-center">
                    <form class="formSearch" action="" method="post" id="formSearchMember">
                        <label for="selectAdherent"></label>
                        <select name="selectAdherent" onchange="getDataMember(this.value)" id="selectAdherent">
                            <option value=" "></option>
                            <?php
                            foreach ($adherents as $adherent) {
                                echo "<option value=\"$adherent->id_adherent\">$adherent->nom_adherent $adherent->prenom_adherent</option>";
                            };
                            ?>
                        </select>
                </div>
                <div class="col-lg-6 col-md-6 mb-4 text-center">
                    <div class="autocomplete">
                        <input type="search" name="txtSearch" placeholder="rechercher..."
                               onkeyup="autoComplete(this, 'autoCompleteMember')" class="searchInput"
                               id="txtSearchAdherent"/>
                        <div class="autocomplete-items" id="autocompleteListAdherent">
                        </div>
                    </div>
                </div>
                    </form>
            </div>


            <div class="row" id="auteur">
                <div class="col-lg-12">
                    <h1 class="searchTitle text-center m-5 text-warning">Recherche par Auteur</h1>
                </div>
                <div class="col-lg-6 col-md-6 mb-4 text-center">
                    <form class="formSearch" action="" method="post" id="formSearchMember">
                        <label for="selectAdherent"></label>
                        <select name="selectAdherent" onchange="getDataAuthor(this.value)" id="selectAdherent">
                            <option value=" "></option>
                            <?php
                            foreach ($authors as $auteur) {
                                echo "<option value=\"$auteur->id_auteur\">$auteur->nom_auteur $auteur->prenom_auteur</option>";
                            };
                            ?>
                        </select>
                </div>
                <div class="col-lg-6 col-md-6 mb-4 text-center">
                    <div class="autocomplete">
                        <input type="search" name="txtSearch" placeholder="rechercher..."
                               onkeyup="autoComplete(this, 'autoCompleteMember')" class="searchInput"
                               id="txtSearchAdherent"/>
                        <div class="autocomplete-items" id="autocompleteListAdherent">
                        </div>
                    </div>
                </div>
                </form>
            </div>


            <div class="row" id="theme">
                <div class="col-lg-12">
                    <h1 class="searchTitle text-center m-5 text-danger">Recherche par Thème</h1>
                </div>
                <div class="col-lg-6 col-md-6 mb-4 text-center">
                    <form class="formSearch" action="" method="post" id="formSearchMember">
                        <label for="selectAdherent"></label>
                        <select name="selectAdherent" onchange="getDataMember(this.value)" id="selectAdherent">
                            <option value=" "></option>
                            <?php
                            foreach ($adherents as $adherent) {
                                echo "<option value=\"$adherent->id_adherent\">$adherent->nom_adherent $adherent->prenom_adherent</option>";
                            };
                            ?>
                        </select>
                </div>
                <div class="col-lg-6 col-md-6 mb-4 text-center">
                    <div class="autocomplete">
                        <input type="search" name="txtSearch" placeholder="rechercher..."
                               onkeyup="autoComplete(this, 'autoCompleteMember')" class="searchInput"
                               id="txtSearchAdherent"/>
                        <div class="autocomplete-items" id="autocompleteListAdherent">
                        </div>
                    </div>
                </div>
                </form>
            </div>


            <div id="displayArea">
                <h1 id="displayAreaTitle"></h1>
                <ul id="listBook">
                </ul>
            </div>
        </div>
        <!-- Fin page Content -->

        <!-- Footer -->
        <footer class="py-3 bg-info fixed-bottom">
            <div class="container text-center">
                <p class="m-0 text-center text-white">Pour les passionnés de livres !!!</p>
                <img src="thumb.png" class="img-fluid rounded" alt="Responsive image" style="width:10%">
            </div>
        </footer>

        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Fin bootstrap core JavaScript -->

        <!-- Ajax custom -->
        <script type="text/javascript" src="./testAjax.js"></script>
        <!-- Fin Ajax custom -->

	</body>

</html>
