<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8" />
  <title>Zoo Arcadia - Découvrez nos animaux et services</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="" name="keywords" />
  <meta name="description" content="Découvrez les animaux du Zoo Arcadia et leurs habitats. Consultez les horaires et les services du zoo.">

  <!-- Favicon -->
  <link href="img/logo.png" rel="logo icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Quicksand:wght@600;700&display=swap"
      rel="stylesheet"
    />

    <!-- Icon Font Stylesheet -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
      rel="stylesheet"
    />

  <!-- Libraries Stylesheet -->
  <link href="lib/animate/animate.min.css" rel="stylesheet" />
  <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet" />
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />

  <!-- Customized Bootstrap Stylesheet -->
  <link href="css/bootstrap.min.css" rel="stylesheet" />

  <!-- Template Stylesheet -->
  <link href="css/style.css" rel="stylesheet" />
</head>

<body>
  <!-- Spinner Start -->
  <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem" role="status">
    <span class="sr-only">Chargement en cours...</span>
    </div>
  </div>
  <!-- Spinner End -->

  <!-- Topbar Start -->
  <div class="container-fluid bg-light p-0 wow fadeIn" data-wow-delay="0.1s">
    <div class="row gx-0 d-none d-lg-flex">
      <div class="col-lg-7 px-5 text-start">
      <div class="h-100 d-inline-flex align-items-center py-3 me-4">
          <a href="https://www.google.com/maps/search/?api=1&query=35000%2C+Rennes%2C+France" target="_blank" class="text-decoration-none">
            <small class="fa fa-map-marker-alt text-primary me-2"></small>
            <small>35000, Rennes, France</small>
          </a>
        </div>

        <div class="h-100 d-inline-flex align-items-center py-3">
    <a href="visiting.php" class="text-decoration-none">
        <small class="far fa-clock text-primary me-2"></small>
        <small>Ouverture du Zoo : 09h00 | Fermeteure : 18h00</small>
    </a>
</div>
      </div>
      <div class="col-lg-5 px-5 text-end">
        <div class="h-100 d-inline-flex align-items-center py-3 me-4">
          <small class="fa fa-phone-alt text-primary me-2"></small>
          <small><a href="tel:+33123456789">+33 1 23 45 67 89</a></small>
        </div>
        <div class="h-100 d-inline-flex align-items-center">
          <a class="btn btn-sm-square bg-white text-primary me-1" href=""><i class="fab fa-facebook-f"></i></a>
          <a class="btn btn-sm-square bg-white text-primary me-1" href=""><i class="fab fa-twitter"></i></a>
          <a class="btn btn-sm-square bg-white text-primary me-1" href=""><i class="fab fa-linkedin-in"></i></a>
          <a class="btn btn-sm-square bg-white text-primary me-0" href=""><i class="fab fa-instagram"></i></a>
        </div>
      </div>
    </div>
  </div>
  <!-- Topbar End -->

  <!-- Navbar Start -->
  <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top py-lg-0 px-4 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
    <a href="../index.php" class="navbar-brand p-0">
      <img class="img-fluid me-3" src="img/logo.png" alt="le logo" />
      <h1 class="m-0 text-primary">Zoo Arcadia</h1>
    </a>
    <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse py-4 py-lg-0" id="navbarCollapse">
      <div class="navbar-nav ms-auto">
        <a href="../index.php" class="nav-item nav-link">Accueil</a>
        <a href="about.php" class="nav-item nav-link">À Propos</a>
        <a href="service.php" class="nav-item nav-link active">Services</a>
        <div class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Habitat</a>
          <div class="dropdown-menu rounded-0 rounded-bottom m-0">
            <a href="habitat.php" class="dropdown-item">Nos habitats</a>
            <a href="details_habitat.php" class="dropdown-item">Nos animaux</a>
            <a href="visiting.php" class="dropdown-item">Heures de Visite</a>
          </div>
        </div>
        <a href="contact.php" class="nav-item nav-link">Contact</a>
        <a href="../back-end/login/login.php" class="nav-item nav-link">Connexion</a>
      </div>
      <a href="#" class="btn btn-primary">Acheter un Billet<i class="fa fa-arrow-right ms-3"></i></a>
    </div>
  </nav>
  <!-- Navbar End -->

  <!-- Page Header Start -->
  <div class="container-fluid header-bg py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
      <h1 class="display-4 text-white mb-3 animated slideInDown">Services</h1>
      <nav aria-label="breadcrumb animated slideInDown">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">
            <a class="text-white" href="#">Home</a>
          </li>
          <li class="breadcrumb-item">
            <a class="text-white" href="#">Pages</a>
          </li>
          <li class="breadcrumb-item text-primary active" aria-current="page">
            Services
          </li>
        </ol>
      </nav>
    </div>
  </div>
  <!-- Page Header End -->

  <!-- Service Start -->
<div class="container-xxl py-5">
  <div class="container">
    <div class="row g-5 mb-5 wow fadeInUp" data-wow-delay="0.1s">
      <div class="col-lg-6">
        <p><span class="text-primary me-2">#</span>Nos Services</p>
        <h1 class="display-5 mb-0">
          Services Spéciaux Pour les
          <span class="text-primary">Visiteurs de Zoofari</span>
        </h1>
      </div>
      <div class="col-lg-6">
        <div class="bg-primary h-100 d-flex align-items-center py-4 px-4 px-sm-5">
          <i class="fa fa-3x fa-mobile-alt text-white"></i>
          <div class="ms-4">
            <p class="text-white mb-0">Appelez pour plus d'infos</p>
            <h2 class="text-white mb-0">+012 345 6789</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="row gy-5 gx-4">
      <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
        <img class="img-fluid mb-3" src="img/icon/icon-2.png" alt="Icon" />
        <h5 class="mb-3">Parking</h5>
        <span>Profitez de notre vaste espace de stationnement sécurisé pour garer votre véhicule en toute tranquillité.</span>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
        <img class="img-fluid mb-3" src="img/icon/icon-3.png" alt="Icon" />
        <h5 class="mb-3">Photos d'Animaux</h5>
        <span>Capturez des souvenirs inoubliables avec nos photographes professionnels spécialisés dans les photos d'animaux.</span>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
        <img class="img-fluid mb-3" src="img/icon/icon-4.png" alt="Icon" />
        <h5 class="mb-3">Services de Guide</h5>
        <span>Explorez le parc avec nos guides expérimentés qui vous fourniront des informations fascinantes sur les animaux et leur habitat.</span>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
        <img class="img-fluid mb-3" src="img/icon/icon-5.png" alt="Icon" />
        <h5 class="mb-3">Nourriture & Boissons</h5>
        <span>Savourez une variété de plats délicieux et de boissons rafraîchissantes dans nos restaurants et cafés.</span>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
        <img class="img-fluid mb-3" src="img/icon/icon-6.png" alt="Icon" />
        <h5 class="mb-3">Boutique Zoo</h5>
        <span>Faites du shopping dans notre boutique de souvenirs pour ramener chez vous des articles uniques et des cadeaux mémorables.</span>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
        <img class="img-fluid mb-3" src="img/icon/icon-7.png" alt="Icon" />
        <h5 class="mb-3">Wi-Fi Gratuit et Rapide</h5>
        <span>Restez connecté avec notre service Wi-Fi gratuit et profitez d'une connexion Internet rapide pendant votre visite.</span>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
        <img class="img-fluid mb-3" src="img/icon/icon-8.png" alt="Icon" />
        <h5 class="mb-3">Aire de Jeux</h5>
        <span>Permettez à vos enfants de s'amuser et de se dépenser dans notre aire de jeux sécurisée et bien équipée.</span>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
        <img class="img-fluid mb-3" src="img/icon/icon-9.png" alt="Icon" />
        <h5 class="mb-3">Maison de Repos</h5>
        <span>Profitez d'un moment de détente et de tranquillité dans nos maisons de repos confortables situées à travers le parc.</span>
      </div>
    </div>
  </div>
</div>
<!-- Service End -->


  <!-- Footer Start -->
  <div class="container-fluid footer bg-dark text-light footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
      <div class="row g-5">
        <div class="col-lg-3 col-md-6">
          <h5 class="text-light mb-4">Adresse</h5>
          <p class="mb-2">
            <i class="fa fa-map-marker-alt me-3"></i>123 rue, Rennes, France
          </p>
          <p class="mb-2">
            <i class="fa fa-phone-alt me-3"></i>+012 345 67890
          </p>
          <p class="mb-2">
            <i class="fa fa-envelope me-3"></i>arcadia78@gmail.com
          </p>
          <div class="d-flex pt-2">
            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <h5 class="text-light mb-4">Liens Rapides</h5>
          <a class="btn btn-link" href="about.php">À propos de nous</a>
          <a class="btn btn-link" href="contact.php">Nous contacter</a>
          <a class="btn btn-link" href="service.php">Nos services</a>
          <a class="btn btn-link" href="#">Termes & Conditions</a>
          <a class="btn btn-link" href="#">Support</a>
        </div>
        <div class="col-lg-3 col-md-6">
          <h5 class="text-light mb-4">Liens Populaires</h5>
          <a class="btn btn-link" href="habitat.php">Nos habitats</a>
          <a class="btn btn-link" href="details_habitat.php">Nos animaux</a>
          <a class="btn btn-link" href="visiting.php">Horaires</a>
          <a class="btn btn-link" href="#">Termes & Conditions</a>
          <a class="btn btn-link" href="#">Support</a>
        </div>

        <div class="col-lg-3 col-md-6">
          <h5 class="text-light mb-2">Laissez un avis</h5>
          <!-- <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p> -->

          <!-- Afficher les messages de succès ou d'erreur -->
          <?php if (isset($_GET['success'])) : ?>
            <div class="alert alert-success">
              <?php echo htmlspecialchars($_GET['success']); ?>
            </div>
          <?php endif; ?>
          <?php if (isset($_GET['error'])) : ?>
            <div class="alert alert-danger">
              <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
          <?php endif; ?>

          <form method="post" action="./back-end/models/employer/submit_comment.php" id="avis-section" onsubmit="return validateForm();">
            <div class="row g-3">
              <div class="col-md-12">
                <div>
                  <input type="text" class="form-control bg-light border-0" id="pseudo" name="pseudo" required />
                  <label class="form-control" for="pseudo">Pseudo :</label>
                </div>
              </div>
              <div class="col-12">
                <div>
                  <textarea class="form-control bg-light border-0" placeholder="Laissez un avis" id="avis" name="avis" rows="3" required></textarea>
                  <label class="form-control" for="avis">Avis :</label>
                  <div id="wordCount" class="form-text">0/150 mots</div>
                </div>
              </div>
              <div class="col-12">
                <!-- Bouton d'envoi -->
                <button class="btn btn-primary w-100 py-3" type="submit">
                  Envoyer
                </button>
              </div>
            </div>
          </form>
        </div>

      </div>
    </div>
    <div class="container">
      <div class="copyright">
        <div class="row">
        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
  &copy;Tous droits réservés. <?php echo date('Y'); ?>
</div>

          <div class="col-md-6 text-center text-md-end">
            <!--/*** Ce modèle est gratuit tant que vous conservez le lien de crédit de l'auteur dans le pied de page. Si vous souhaitez utiliser le modèle sans le lien de crédit de l'auteur, vous pouvez acheter la licence de suppression de crédit sur "https://htmlcodex.com/credit-removal". Merci pour votre soutien. ***/-->
            Conçu par
            <a class="border-bottom" target="_blank" href="https://github.com/N-ahmadzai">Ahmadzai</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"
      ><i class="bi bi-arrow-up"></i
    ></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
  </body>
</html>
