<link rel="stylesheet" href="style.css" type="text/css" media="all" />

  <?php
  include_once '../../Controller/projetC.php';
  $co = new projetC();
  if(isset($_GET['id'])){
    $projetC = new projetC();
    $listeC =$projetC->afficherProjetDetail($_GET['id']);
    foreach($listeC as $projet){
  ?>

  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>5ademni Admin Panel</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon" />
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet" />
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet" />
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet" />
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet" />
    </head>

  <body class="bg-gradient-primary">

      <div class="container">

          <div class="card o-hidden border-0 shadow-lg my-5">
              <div class="card-body p-0">
                  <!-- Nested Row within Card Body -->
                  <div class="row">
                      <div class="C:\xampp\htdocs\Final\Views\backend\modif.gif"></div>
                      <div class="col-lg-7">
                          <div class="p-1">
                              <div class="text-center">
                              </div>
    <form action="#" method="post">
    <!-- Box -->
    <div class="box">
            <!-- Box Head -->
            <div class="container">
              <h2>Modifier projet</h2>
            </div>
            <!-- End Box Head -->
              <!-- Form -->
              <div class="container">
                <p> 
                  <label>Nom Projet </label>
                  <input type="text" class="form-control form-control-user" name="nom_projet" value=<?php echo $projet ['nompr'];?> />
                </p>
                <p> 
                <p> 
                  <label>Nom Realisateur </label>
                  <input type="text" class="form-control form-control-user" name="nom_realisateur" value=<?php echo $projet ['nom_realisateur'];?> />
                </p>
                <p> 
                  <label>Niveau Etudes </label>
                  <input type="text" class="form-control form-control-user" name="niveau_etudes" value=<?php echo $projet ['niveau_etudes'];?> />
                </p>
                <p> 
                <p> 
                  <label>Email </label>
                  <input type="text" class="form-control form-control-user" name="email" value=<?php echo $projet ['email'];?> />
                </p>
                <p> 
                  <label>Time </label>
                  <input type="int" class="form-control form-control-user" name="time" value=<?php echo $projet ['time'];?> />
                </p>
                <p> 
                  <label>Domaine </label>
                  <input type="text" class="form-control form-control-user" name="domaine" value=<?php echo $projet ['domaine'];?> />
                </p>
                <p> 
                  <label>Budget </label>
                  <input type="int" class="form-control form-control-user" name="budget" value=<?php echo $projet ['budget'];?> />
                </p>
                <p> 
                  <label>Description </label>
                  <input type="text" class="form-control form-control-user" name="description" value=<?php echo $projet ['description'];}?> />
                </p>

              </div>
              <!-- End Form -->
              <!-- Form Buttons -->
              <div class="buttons">
                <input type="Reset" class="button" value="Reset" />
                <input type="submit" class="button" value="submit" />
              </div>
              <!-- End Form Buttons -->
            </form>
  </div>
  </div>
  </body>


  <?php
  // create event
  $projet = null;

  // create an instance of the controller

  $projetC = new projetC();
  if (
      isset($_POST["nom_projet"]) && 
      isset($_POST["nom_realisateur"]) && 
      isset($_POST["niveau_etudes"]) && 
      isset($_POST["email"]) && 
      isset($_POST["time"]) &&
      isset($_POST["domaine"]) &&
      isset($_POST["budget"]) &&
      isset($_POST["description"])
  ) {
      if (
          !empty($_POST["nom_projet"]) &&
          !empty($_POST["nom_realisatur"]) &&
          !empty($_POST["niveau_etudes"]) &&  
          !empty($_POST["email"]) && 
          !empty($_POST["time"]) &&
          !empty($_POST["domaine"]) &&
          !empty($_POST["budget"]) && 
          !empty($_POST["description"]) 
      ) {
          $projet = new projet(
              $_POST['nom_projet'],
              $_POST['nom_realisatur'],
              $_POST['niveau_etudes'],
              $_POST['email'],
              $_POST['time'],
              $_POST['domaine'],
              $_POST['budget'],
              $_POST['description']
          );
          $projetC->modifierProjet($_GET['id'],$projet);
          
          header('Location:developpement.php');
      }
      else
          $error = "Missing information";
  }
  }
  ?>
