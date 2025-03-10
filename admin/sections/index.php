<?php
include_once '../includes/__header.php';
include_once '../includes/__navbar.php';
?>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3"><strong>Sections</strong> List</h1>
        <div class="row">
            <div class="col-sm-6 col-xl-3 mb-4">
                <a href="settings.php?section=sales" class="text-decoration-none">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <div class="stat text-primary mr-3">
                                <i class="align-middle" data-feather="truck"></i>
                            </div>
                            <h5 class="card-title mb-0">Sales</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-3 mb-4">
                <a href="settings.php?section=visitors" class="text-decoration-none">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <div class="stat text-primary mr-3">
                                <i class="align-middle" data-feather="users"></i>
                            </div>
                            <h5 class="card-title mb-0">Visitors</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-3 mb-4">
                <a href="settings.php?section=earnings" class="text-decoration-none">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <div class="stat text-primary mr-3">
                                <i class="align-middle" data-feather="dollar-sign"></i>
                            </div>
                            <h5 class="card-title mb-0">Earnings</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-3 mb-4">
                <a href="settings.php?section=orders" class="text-decoration-none">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <div class="stat text-primary mr-3">
                                <i class="align-middle" data-feather="shopping-cart"></i>
                            </div>
                            <h5 class="card-title mb-0">Orders</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</main>

<?php include_once '../includes/__footer.php'; ?>