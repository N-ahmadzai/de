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
      <span class="sr-only">Loading...</span>
    </div>
  </div>
  <!-- Spinner End -->

  <!-- Topbar Start -->
  <div class="container-fluid bg-light p-0 wow fadeIn" data-wow-delay="0.1s">
    <div class="row gx-0 d-none d-lg-flex">
      <div class="col-lg-7 px-5 text-start">
        <div class="h-100 d-inline-flex align-items-center py-3 me-4">
          <small class="fa fa-map-marker-alt text-primary me-2"></small>
          <small>35000, Rennes, France</small>
        </div>
        <div class="h-100 d-inline-flex align-items-center py-3">
          <small class="far fa-clock text-primary me-2"></small>
          <small>Ouverture du Zoo : 10h00 | Sortie de tous les visiteurs : 17h00</small>
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
        <a href="../index.php" class="nav-item nav-link active">Home</a>
        <a href="about.php" class="nav-item nav-link">About</a>
        <a href="service.php" class="nav-item nav-link">Services</a>
        <div class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
          <div class="dropdown-menu rounded-0 rounded-bottom m-0">
            <a href="animal.php" class="dropdown-item">Our Animals</a>
            <a href="membership.php" class="dropdown-item">Membership</a>
            <a href="visiting.php" class="dropdown-item">Visiting Hours</a>
            <a href="testimonial.php" class="dropdown-item">Testimonial</a>
            <a href="404.php" class="dropdown-item">404 Page</a>
          </div>
        </div>
        <a href="contact.php" class="nav-item nav-link">Contact</a>

        <div class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">connexion</a>
          <div class="dropdown-menu rounded-0 rounded-bottom m-0">
            <a href="animal.php" class="dropdown-item">Admin</a>
            <a href="membership.php" class="dropdown-item">Employer</a>
            <a href="visiting.php" class="dropdown-item">Veterinaire</a>
          </div>
        </div>
      </div>
      <a href="" class="btn btn-primary">Buy Ticket<i class="fa fa-arrow-right ms-3"></i></a>
    </div>
  </nav>
  <!-- Navbar End -->

  <!-- Page Header Start -->
  <div class="container-fluid header-bg py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
      <h1 class="display-4 text-white mb-3 animated slideInDown">
        Membership
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
            Membership
          </li>
        </ol>
      </nav>
    </div>
  </div>
  <!-- Page Header End -->

  <!-- Membership Start -->
  <div class="container-xxl py-5">
    <div class="container">
      <div class="row g-5 mb-5 align-items-end wow fadeInUp" data-wow-delay="0.1s">
        <div class="col-lg-6">
          <p><span class="text-primary me-2">#</span>Membership</p>
          <h1 class="display-5 mb-0">
            You Can Be A Proud Member Of
            <span class="text-primary">Zoofari</span>
          </h1>
        </div>
        <div class="col-lg-6 text-lg-end">
          <a class="btn btn-primary py-3 px-5" href="">Special Pricing</a>
        </div>
      </div>
      <div class="row g-4">
        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
          <div class="membership-item position-relative">
            <img class="img-fluid" src="img/animal-lg-1.jpg" alt="" />
            <h1 class="display-1">01</h1>
            <h4 class="text-white mb-3">Popular</h4>
            <h3 class="text-primary mb-4">$99.00</h3>
            <p><i class="fa fa-check text-primary me-3"></i>10% discount</p>
            <p>
              <i class="fa fa-check text-primary me-3"></i>2 adult and 2 child
            </p>
            <p>
              <i class="fa fa-check text-primary me-3"></i>Free animal
              exhibition
            </p>
            <a class="btn btn-outline-light px-4 mt-3" href="">Get Started</a>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
          <div class="membership-item position-relative">
            <img class="img-fluid" src="img/animal-lg-2.jpg" alt="" />
            <h1 class="display-1">02</h1>
            <h4 class="text-white mb-3">Standard</h4>
            <h3 class="text-primary mb-4">$149.00</h3>
            <p><i class="fa fa-check text-primary me-3"></i>15% discount</p>
            <p>
              <i class="fa fa-check text-primary me-3"></i>4 adult and 4 child
            </p>
            <p>
              <i class="fa fa-check text-primary me-3"></i>Free animal
              exhibition
            </p>
            <a class="btn btn-outline-light px-4 mt-3" href="">Get Started</a>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
          <div class="membership-item position-relative">
            <img class="img-fluid" src="img/animal-lg-3.jpg" alt="" />
            <h1 class="display-1">03</h1>
            <h4 class="text-white mb-3">Premium</h4>
            <h3 class="text-primary mb-4">$199.00</h3>
            <p><i class="fa fa-check text-primary me-3"></i>20% discount</p>
            <p>
              <i class="fa fa-check text-primary me-3"></i>6 adult and 6 child
            </p>
            <p>
              <i class="fa fa-check text-primary me-3"></i>Free animal
              exhibition
            </p>
            <a class="btn btn-outline-light px-4 mt-3" href="">Get Started</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Membership End -->

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
          <a class="btn btn-link" href="">Terms & Condition</a>
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
          <div class="position-relative mx-auto" style="max-width: 400px">
            <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email" />
            <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">
              SignUp
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="copyright">
        <div class="row">
          <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
            &copy; <a class="border-bottom" href="#">Your Site Name</a>, All
            Right Reserved.
          </div>
          <div class="col-md-6 text-center text-md-end">
            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
            Designed By
            <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
            <br />Distributed By:
            <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
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
