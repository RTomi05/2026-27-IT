<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <title>Doga - 10. 09.</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <header class="col-12">
                <div class="container">
<!--Innen van: https://getbootstrap.com/docs/5.0/examples/headers/ (1. példa)-->
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a href="<?php uri(3);?>" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <span class="fs-4">Menüvezérelt dinamikus oldal, űrlappal</span>
      </a>
    </header>
  </div>
            <!--<h1>PHP feldolgozás</h1>-->
        <?php include("include/navbar.php");?>
        </div>
        <div class="col-12">
            <?php echo $mainContent;?>
        </div>
<!--Innen van: https://getbootstrap.com/docs/5.3/examples/footers/ (2. példa)-->
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top"> <div class="col-md-4 d-flex align-items-center"> <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1" aria-label="Bootstrap">  </a> <span class="mb-3 mb-md-0 text-body-secondary">© Rengel Tamás, 2026. 10. 09.</span> </div> <ul class="nav col-md-4 justify-content-end list-unstyled d-flex"> <li class="ms-3"><a class="text-body-secondary" href="#" aria-label="Instagram"></a></li> <li class="ms-3"><a class="text-body-secondary" href="#" aria-label="Facebook"><svg class="bi" width="24" height="24"></svg></a></li> </ul></footer>
        </div>
    </div>
</body>
</html>