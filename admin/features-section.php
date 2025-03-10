<?php
include_once './includes/__header.php';
include_once './includes/__navbar.php';

// Handle form submission
$iconMessage = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['iconName'])) {
    $iconName = $_POST['iconName'];
    $iconMessage = "Icon '$iconName' copied";
}
?>

<!-- Include Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3 text-center"><strong>Features</strong></h1>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <form id="featureForm">
                            <div class="form-group mb-3">
                                <label for="featureTitle1">Title</label>
                                <input type="text" class="form-control" id="featureTitle1" placeholder="Enter title">
                            </div>
                            <div class="form-group mb-3">
                                <label for="featureDescription1">Description</label>
                                <textarea class="form-control" id="featureDescription1" rows="3" placeholder="Enter description"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="featureIcon1">Select Icon</label>
                                <input type="text" class="form-control icon-picker" id="featureIcon1" placeholder="Enter icon class (e.g., fa fa-home)">
                            </div>
                            <div class="form-group mb-3">
                                <label for="featureTitle2">Title</label>
                                <input type="text" class="form-control" id="featureTitle2" placeholder="Enter title">
                            </div>
                            <div class="form-group mb-3">
                                <label for="featureDescription2">Description</label>
                                <textarea class="form-control" id="featureDescription2" rows="3" placeholder="Enter description"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="featureIcon2">Select Icon</label>
                                <input type="text" class="form-control icon-picker" id="featureIcon2" placeholder="Enter icon class (e.g., fa fa-home)">
                            </div>
                            <div class="form-group mb-3">
                                <label for="featureTitle3">Title</label>
                                <input type="text" class="form-control" id="featureTitle3" placeholder="Enter title">
                            </div>
                            <div class="form-group mb-3">
                                <label for="featureDescription3">Description</label>
                                <textarea class="form-control" id="featureDescription3" rows="3" placeholder="Enter description"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="featureIcon3">Select Icon</label>
                                <input type="text" class="form-control icon-picker" id="featureIcon3" placeholder="Enter icon class (e.g., fa fa-home)">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
                <?php if ($iconMessage): ?>
                    <div class="alert alert-success text-center">
                        <?php echo $iconMessage; ?>
                    </div>
                <?php endif; ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Select an Icon</h5>
                        <div class="row">
                            <?php
                            $icons = [
                                'fa fa-home', 'fa fa-user', 'fa fa-envelope', 'fa fa-phone', 'fa fa-cog', 'fa fa-heart',
                                'fa fa-star', 'fa fa-check', 'fa fa-times', 'fa fa-search', 'fa fa-camera', 'fa fa-comments',
                                'fa fa-bell', 'fa fa-calendar', 'fa fa-cloud', 'fa fa-gift', 'fa fa-lock', 'fa fa-shopping-cart',
                                'fa fa-tag', 'fa fa-wrench', 'fa fa-leaf', 'fa fa-lightbulb', 'fa fa-music', 'fa fa-paper-plane',
                                'fa fa-puzzle-piece', 'fa fa-rocket', 'fa fa-shield', 'fa fa-thumbs-up', 'fa fa-trophy', 'fa fa-umbrella'
                            ];
                            foreach ($icons as $icon) {
                                echo '<div class="col-sm-2 text-center mb-3">';
                                echo '<form method="POST" action="">';
                                echo '<input type="hidden" name="iconName" value="' . $icon . '">';
                                echo '<button type="submit" class="btn btn-link p-0">';
                                echo '<i class="' . $icon . ' fa-2x"></i>';
                                echo '</button>';
                                echo '</form>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include_once './includes/__footer.php'; ?>