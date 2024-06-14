<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>HOMEPAGE</title>
    <style>
       @import url('https://fonts.googleapis.com/css2?family=Protest+Guerrilla&display=swap');
      .container-fluid {
          grid-template-columns: 1fr;
      }
        
              
      .bg-image {
          background-image: url('homepage.png');
          background-size: cover;
          background-position: center;
          height: 100vh;
          display: flex;
          align-items: center;
          justify-content: center;
      }

      .content {
          text-align: center;
          color: white;
      }
    </style>
</head>
<body>
    <!-- nav section start -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand fw-semibold text-dark" href="index.php" style="font-family: 'Protest Guerrilla', sans-serif; font-size: 30px;">
      <img src="logo.png" alt="Logo" width="35" height="35" class="d-inline-block align-text-top">
      <i class="text-black"> Aksatal </i>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="nav justify-content-end me-auto">  <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="home.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#contact">Contact</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="/" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Other
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="https://cs.unsika.ac.id/">FASILKOM</a></li>
            <li><a class="dropdown-item" href="https://fkip.unsika.ac.id/">FKIP</a></li>
            <li><a class="dropdown-item" href="https://fh.unsika.ac.id/">FH</a></li>
            <li><a class="dropdown-item" href="https://fe.unsika.ac.id/">FE</a></li>
            <li><a class="dropdown-item" href="https://faperta.unsika.ac.id/">FAPERTA</a></li>
            <li><a class="dropdown-item" href="https://fai.unsika.ac.id/">FAI</a></li>
            <li><a class="dropdown-item" href="https://ft.unsika.ac.id/">FT</a></li>
            <li><a class="dropdown-item" href="https://fisip.unsika.ac.id/">FISIP</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="btn btn-primary" href="login.php" role="button">log In</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

    <!-- nav section end -->
   
    <!-- homepage start -->
    <div class="bg-image">
        <div class="content">
            <h1>WELCOME TO AKSATAL</h1>
            <p>Improve your theory of mind, today a reader, tomorrow a leader!</p>
        </div>
    </div>
    
    <!-- homepage end-->


<!--  about start -->


    <section class="py-3 py-md-5" id="about">
        <div class="container">
          <div class="row gy-3 gy-md-4 gy-lg-0 align-items-lg-center">
            <div class="col-12 col-lg-6 col-xl-5">
              <img class="img-fluid rounded" loading="lazy" src="about.png" alt="About 1">
            </div>
            <div class="col-12 col-lg-6 col-xl-7">
              <div class="row justify-content-xl-center">
                <div class="col-12 col-xl-11">
                  <h2 class="mb-3">AKSATAL itu apa sih?</h2>
                  <p class="lead fs-4 text-secondary mb-3">Gerbang Menuju Dunia Literasi dan Karya Tulis UNIVERSITAS SINGAPERBANGSA KARAWANG.</p>
                  <p class="mb-5">AKSATAL hadir sebagai wadah bagi para penulis, peneliti, dan pencinta ilmu untuk mencari, melihat, dan mengunggah karya tulis mereka, seperti makalah dan jurnal. Tidak hanya berfungsi sebagai repositori karya tulis, tetapi juga sebagai komunitas bagi para pencinta ilmu. Pengguna dapat memberikan komentar dan ulasan pada karya tulis yang mereka baca, membuka ruang diskusi dan pertukaran ide.</p>
                  <div class="row gy-4 gy-md-0 gx-xxl-5X">
                    <div class="col-12 col-md-6">
                      <div class="d-flex">
                        <div class="me-4 text-primary">
                          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-fire" viewBox="0 0 16 16">
                            <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                          </svg>
                        </div>
                        <div>
                          <h2 class="h4 mb-3">MAKALAH</h2>
                          <p class="text-secondary mb-0">Makalah adalah karya tulis ilmiah yang membahas suatu pokok bahasan tertentu secara sistematis dan logis, dengan tujuan untuk memberikan informasi, pengetahuan, dan pemahaman kepada pembaca.</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="d-flex">
                        <div class="me-4 text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-fire" viewBox="0 0 16 16">
                                <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                              </svg>
                        </div>
                        <div>
                          <h2 class="h4 mb-3">JURNAL</h2>
                          <p class="text-secondary mb-0">Jurnal merupakan salah satu media yang digunakan untuk menyajikan hasil penelitian atau kajian ilmiah dalam bentuk tulisan. Jurnal memiliki peran yang sangat penting dalam menyebarluaskan pengetahuan dan informasi.</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- about end -->
      
      <!-- contact start -->

  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!------ Include the above in your HEAD tag ---------->
  
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
  
  <div class="container-fluid" id="contact">
      <h1 class="text-center">Contact Address</h1>
      <hr>
      <div class="container-fluid">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126897.46300668558!2d107.17456246249999!3d-6.323239800000005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6977ccb34822e1%3A0x6c4c7c12678610e0!2sUniversitas%20Singaperbangsa%20Karawang%20(UNSIKA)!5e0!3m2!1sid!2sid!4v1714917267225!5m2!1sid!2sid" width="100%" height="320" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" width="100%" height="100vh" frameborder="0" style="border:0" allowfullscreen></iframe>
      </div>
      <div class="row text-center">
          <div class="col-4 box1 pt-4">
            <a href="tel:(0267)641177"><i class="fas fa-phone fa-3x"></i>
            <h3 class="d-none d-lg-block d-xl-block">Phone</h3>
            <p class="d-none d-lg-block d-xl-block">(0267)641177</p></a>
          </div>
          <div class="col-4 box2 pt-4">
            <a href=""><i class="fas fa-home fa-3x"></i>
            <h3 class="d-none d-lg-block d-xl-block">Address</h3>
            <p class="d-none d-lg-block d-xl-block">Jl. HS. Ronggo Waluyo, Telukjambe Timur, Karawang, Jawa Barat, Indonesia - 41361</p></a>
          </div>
          <div class="col-4 box3 pt-4">
            <a href="mailto:info@unsika.ac.id"><i class="fas fa-envelope fa-3x"></i>
            <h3 class="d-none d-lg-block d-xl-block">E-mail</h3>
            <p class="d-none d-lg-block d-xl-block">info@unsika.ac.id</p></a>
          </div>
      </div>
  </div>

  <!-- contact end -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>