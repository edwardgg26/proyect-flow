<nav class="navbar navbar-dark text-bg-<?php echo $colores??"primary";?> sticky-top">
  <div class="container-fluid">
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <p class="m-0 d-none d-sm-block">Hola, <span class="fw-bold"><?php echo $nombre?></span></p>
    <a class="navbar-brand fw-bold" href="/dashboard">ProyectFlow</a>
    
    <div class="offcanvas offcanvas-start text-bg-<?php echo $colores??"primary";?>" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">ProyectFlow</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
                <a class="nav-link <?php echo ($titulo == "Mi Dashboard")? "active":""?>" aria-current="page" href="/dashboard">Mi Dashboard</a>
                <a class="nav-link <?php echo ($titulo == "Mi Perfil")? "active":""?>" aria-current="page" href="/perfil">Perfil</a>
                <a class="nav-link" aria-current="page" href="/logout">Cerrar Sesión</a>
            </li>
        </ul>
      </div>
    </div>
  </div>
</nav>