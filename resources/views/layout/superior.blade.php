<nav class="navbar-classic navbar navbar-expand-lg">
    <a id="nav-toggle" href="#"><i data-feather="menu" class="nav-icon me-2 icon-xs"></i></a>
    <div class="ms-lg-3 d-none d-md-none d-lg-block">
        <!-- Form -->
        <form class="d-flex align-items-center">
            <input type="search" class="form-control" placeholder="Busca aqui" />
        </form>
    </div>
    <!--Navbar nav -->
    <ul class="navbar-nav navbar-right-wrap ms-auto d-flex nav-top-wrap">
        <li class="dropdown stopevent">
            <a class="btn btn-light btn-icon rounded-circle indicator indicator-primary text-muted"
                href="#" role="button" id="dropdownNotification" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="icon-xs" data-feather="bell"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end"
                aria-labelledby="dropdownNotification">
                <div>
                    <div
                        class="border-bottom px-3 pt-2 pb-3 d-flex justify-content-between align-items-center">
                        <p class="mb-0 text-dark fw-medium fs-4">Notificaciones</p>
                    </div>
                    <!-- List group -->
                    <!--<ul class="list-group list-group-flush notification-list-scroll">
                        <li class="list-group-item bg-light">


                            <a href="#" class="text-muted">
                                <h5 class=" mb-1">Rishi Chopra</h5>
                                <p class="mb-0">
                                    Mauris blandit erat id nunc blandit, ac eleifend dolor pretium.
                                </p>
                            </a>



                        </li>
                        <li class="list-group-item">


                            <a href="#" class="text-muted">
                                <h5 class=" mb-1">Neha Kannned</h5>
                                <p class="mb-0">
                                    Proin at elit vel est condimentum elementum id in ante. Maecenas et
                                    sapien metus.
                                </p>
                            </a>



                        </li>
                        <li class="list-group-item">


                            <a href="#" class="text-muted">
                                <h5 class=" mb-1">Nirmala Chauhan</h5>
                                <p class="mb-0">
                                    Morbi maximus urna lobortis elit sollicitudin sollicitudieget elit
                                    vel pretium.
                                </p>
                            </a>



                        </li>
                        <li class="list-group-item">


                            <a href="#" class="text-muted">
                                <h5 class=" mb-1">Sina Ray</h5>
                                <p class="mb-0">
                                    Sed aliquam augue sit amet mauris volutpat hendrerit sed nunc eu
                                    diam.
                                </p>
                            </a>



                        </li>
                    </ul>-->
                    <div class="border-top px-3 py-2 text-center">
                        <a href="#" class="text-inherit fw-semi-bold">
                            Ver todas
                        </a>
                    </div>
                </div>
            </div>
        </li>
        <!-- List -->
        <li class="dropdown ms-2">
            <a class="rounded-circle" href="#" role="button" id="dropdownUser"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="avatar avatar-md avatar-indicators avatar-online">
                    <img alt="avatar" src="{{ $user->people->gender == 'F' ? asset('images/women.png') : asset('images/men.png')}}"
                        class="rounded-circle" />
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                <div class="px-4 pb-0 pt-2">


                    <div class="lh-1 ">
                        <h5 class="mb-1"> {{ $user->people->names() }}</h5>
                        <a href="#" class="text-inherit fs-6">Ver mi perfil</a>
                    </div>
                    <div class=" dropdown-divider mt-3 mb-2"></div>
                </div>

                <ul class="list-unstyled">

                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="me-2 icon-xxs dropdown-item-icon" data-feather="user"></i>Editar mi perfil
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="me-2 icon-xxs dropdown-item-icon"
                                data-feather="activity"></i>Registro de actividad
                        </a>
                    </li>
                    
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}">
                            <i class="me-2 icon-xxs dropdown-item-icon" data-feather="power"></i>Salir
                        </a>
                    </li>
                </ul>

            </div>
        </li>
    </ul>
</nav>
