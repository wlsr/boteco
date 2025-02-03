<?php
$user = $_SESSION['logged_name'];
?>
<!DOCTYPE html>
<html lang="en">
<body>
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" style="letter-spacing: 8px; font-family: Helvetica; font-size: 17px;" href="#">
                Adega J.A.K
            </a>
            <a class="fw-bold text-left">
              <i class="fa fa-solid fa-user"></i> <strong><?php echo ucfirst($user); ?></strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" style="background-color: #617181; width: 200px;" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                  <div class="container">
                    <div class="px-4">
                        <img src="img/perfil.png" alt="Logo" class="profile-img ">
                    </div>
                    <ul class="navbar-nav justify-content-end flex-grow-1">
                      
                   
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="home.php"><i class="fa fa-solid fa-shopping-cart"></i> Ventas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="item.php"><i class="fa fa-solid fa-tags"></i> Productos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="product.php"><i class="fa fa-solid fa-th-list"></i> Stock</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="stock.php"><i class="fa fa-solid fa-folder-open"></i> Inventario</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="salesALL.php"><i class="fa fa-solid fa-bitcoin"></i> Total Ventas</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="masVendidos.php"><i class="fa fa-solid fa-line-chart"></i> Reportes</a></li>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="history.php"><i class="fa fa-solid fa-file-text"></i> Historial</a>
                        </li>
                        <li class="nav-item close-sesion-nav position-absolute bottom-0">
                            <a class="nav-link" style="color: #AA3545" href="logout.php"><i class="fa fa-power-off"></i> Cerrar Sesión</a>
                        </li>
                    </ul>
                  </div>
                </div>
            </div>
        </div>
    </nav>

    </body>
</html>