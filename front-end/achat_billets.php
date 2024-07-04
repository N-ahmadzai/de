<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <title>Achat de Billets - Zoo Arcadia</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="" name="keywords" />
  <meta name="description" content="Achetez vos billets pour le Zoo Arcadia en ligne.">

  <!-- Favicon -->
  <link href="img/logo.png" rel="logo icon" />

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Quicksand:wght@600;700&display=swap" rel="stylesheet" />

  <!-- Icon Font Stylesheet -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

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
        <a href="about.php" class="nav-item nav-link ">À Propos</a>
        <a href="service.php" class="nav-item nav-link">Services</a>
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
      <a href="#" class="btn btn-primary active">Acheter un Billet<i class="fa fa-arrow-right ms-3"></i></a>
    </div>
  </nav>
  <!-- Navbar End -->

  <!-- Page Header Start -->
  <div class="container-fluid header-bg py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
      <h1 class="display-4 text-white mb-3 animated slideInDown">
        Achat de Billets
      </h1>
      <nav aria-label="breadcrumb animated slideInDown">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">
            <a class="text-white" href="#">Home</a>
          </li>
          <li class="breadcrumb-item">
            <a class="text-white" href="#">Pages</a>
          </li>
          <li class="breadcrumb-item text-primary active" aria-current="page">
            Achat de Billets
          </li>
        </ol>
      </nav>
    </div>
  </div>
  <!-- Page Header End -->

  <!-- Ticket Purchase Start -->
  <div class="container mt-5">
    <h2 class="text-center mb-4">Achat de Billets - Zoo Arcadia</h2>
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="card">
          <div class="card-body">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              <div class="mb-3">
                <label for="adult_tickets" class="form-label">Nombre de billets adultes (16 ans et plus)</label>
                <input type="number" class="form-control" id="adult_tickets" name="adult_tickets" min="1" required>
              </div>
              <div class="mb-3">
                <label for="child_tickets" class="form-label">Nombre de billets enfants (de 5 à 15 ans)</label>
                <input type="number" class="form-control" id="child_tickets" name="child_tickets" min="0" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Adresse Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <hr>
              <h4 class="mb-3">Paiement par Carte Bancaire</h4>
              <div class="mb-3">
                <label for="card_number" class="form-label">Numéro de Carte Bancaire</label>
                <input type="text" class="form-control" id="card_number" name="card_number" required>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label for="card_expiry" class="form-label">Date d'Expiration</label>
                  <input type="text" class="form-control" id="card_expiry" name="card_expiry" placeholder="MM/YY" required>
                </div>
                <div class="col-md-6">
                  <label for="card_cvv" class="form-label">CVV</label>
                  <input type="text" class="form-control" id="card_cvv" name="card_cvv" maxlength="3" required>
                </div>
              </div>
              <button type="submit" class="btn btn-primary mt-3">Acheter</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Ticket Purchase End -->

  <!-- Footer Start -->
  <div class="container-fluid footer bg-dark text-light footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
      <div class="row g-5">
        <div class="col-lg-3 col-md-6">
          <h5 class="text-light mb-4">Address</h5>
          <p class="mb-2">
            <i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA
          </p>
          <p class="mb-2">
            <i class="fa fa-phone-alt me-3"></i>+012 345 67890
          </p>
          <p class="mb-2">
            <i class="fa fa-envelope me-3"></i>info@example.com
          </p>
          <div class="d-flex pt-2">
            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <h5 class="text-light mb-4">Quick Links</h5>
          <a class="btn btn-link" href="">About Us</a>
          <a class="btn btn-link" href="">Contact Us</a>
          <a class="btn btn-link" href="">Our Services</a>
          <a class="btn btn-link" href="">Terms & Condition
          </a>
          <a class="btn btn-link" href="">Support</a>
        </div>
        <div class="col-lg-3 col-md-6">
          <h5 class="text-light mb-4">Popular Links</h5>
          <a class="btn btn-link" href="">About Us</a>
          <a class="btn btn-link" href="">Contact Us</a>
          <a class="btn btn-link" href="">Our Services</a>
          <a class="btn btn-link" href="">Terms & Condition</a>
          <a class="btn btn-link" href="">Support</a>
        </div>
        <div class="col-lg-3 col-md-6">
          <h5 class="text-light mb-4">Newsletter</h5>
          <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
          <div class="position-relative mx-auto" style="max-width: 400px;">
            <input type="email" class="form-control mb-2" placeholder="Your Email">
            <button type="button" class="btn btn-primary">Subscribe</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer End -->

  <!-- Back to Top Start -->
  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <!-- Back to Top End -->

  <!-- JavaScript Libraries -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>

  <!-- Template Main Javascript File -->
  <script src="js/main.js"></script>

  <!-- PHP Payment Processing -->
  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Simulation du traitement de paiement (à remplacer avec votre logique de traitement réel)
    $adult_tickets = $_POST['adult_tickets'];
    $child_tickets = $_POST['child_tickets'];
    $email = $_POST['email'];
    $card_number = $_POST['card_number'];
    $card_expiry = $_POST['card_expiry'];
    $card_cvv = $_POST['card_cvv'];

    // Ici, vous pouvez implémenter la logique de validation et de traitement du paiement

    // Redirection vers une page de confirmation après traitement
    header("Location: confirmation.php");
    exit();
  }
  ?>
</body>
</html>
