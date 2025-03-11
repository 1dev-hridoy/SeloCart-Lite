<?php
// Start output buffering at the very beginning of the file
ob_start();

include_once './includes/__header.php';
include_once './includes/__navbar.php';

// Initialize alert variables
$showAlert = false;
$alertMessage = '';
$alertType = '';

// Fetch existing features data
$features = $pdo->query("SELECT * FROM features ORDER BY id ASC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $featuresData = [
        [
            'id' => 1,
            'name' => $_POST['featureTitle1'],
            'description' => $_POST['featureDescription1'],
            'icon_name' => $_POST['featureIcon1']
        ],
        [
            'id' => 2,
            'name' => $_POST['featureTitle2'],
            'description' => $_POST['featureDescription2'],
            'icon_name' => $_POST['featureIcon2']
        ],
        [
            'id' => 3,
            'name' => $_POST['featureTitle3'],
            'description' => $_POST['featureDescription3'],
            'icon_name' => $_POST['featureIcon3']
        ]
    ];

    try {
        foreach ($featuresData as $feature) {
            $stmt = $pdo->prepare("INSERT INTO features (id, name, description, icon_name) VALUES (?, ?, ?, ?)
                                ON DUPLICATE KEY UPDATE name = VALUES(name), description = VALUES(description), icon_name = VALUES(icon_name), updated_at = NOW()");
            $stmt->execute([$feature['id'], $feature['name'], $feature['description'], $feature['icon_name']]);
        }
        $_SESSION['alert_message'] = "Features updated successfully!";
        $_SESSION['alert_type'] = "success";
    } catch (PDOException $e) {
        $_SESSION['alert_message'] = "Error: " . $e->getMessage();
        $_SESSION['alert_type'] = "danger";
    }

    // Redirect to the same page to display updated data
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Check for session messages
if (isset($_SESSION['alert_message']) && isset($_SESSION['alert_type'])) {
    $alertMessage = $_SESSION['alert_message'];
    $alertType = $_SESSION['alert_type'];
    $showAlert = true;

    // Clear the session variables after using them
    unset($_SESSION['alert_message']);
    unset($_SESSION['alert_type']);
}
?>

<!-- Include Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    .icon-card {
        transition: transform 0.2s ease-in-out;
    }
    .icon-card:hover {
        transform: scale(1.1);
    }
    .icon-card i {
        cursor: pointer;
    }
    .icon-card p {
        margin-top: 10px;
        font-size: 14px;
        font-weight: bold;
    }
    .alert {
        margin-top: 20px;
    }
</style>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3 text-center"><strong>Features</strong></h1>
        
        <!-- Alert Message (hidden by default) -->
        <?php if ($showAlert): ?>
        <div id="alertBox" class="alert alert-<?= $alertType ?>" role="alert">
            <?= htmlspecialchars($alertMessage) ?>
            <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <form id="featureForm" method="POST">
                            
                            <!-- Feature 1 -->
                            <h5>Feature 1</h5>
                            <div class="form-group mb-3">
                                <label for="featureTitle1">Title</label>
                                <input type="text" class="form-control" id="featureTitle1" name="featureTitle1" placeholder="Enter title" value="<?= htmlspecialchars($features[0]['name'] ?? '') ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label for="featureDescription1">Description</label>
                                <textarea class="form-control" id="featureDescription1" name="featureDescription1" rows="3" placeholder="Enter description"><?= htmlspecialchars($features[0]['description'] ?? '') ?></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="featureIcon1">Icon Name</label>
                                <input type="text" class="form-control" id="featureIcon1" name="featureIcon1" placeholder="Enter icon class (e.g., fa fa-home)" value="<?= htmlspecialchars($features[0]['icon_name'] ?? '') ?>">
                            </div>

                            <!-- Feature 2 -->
                            <h5>Feature 2</h5>
                            <div class="form-group mb-3">
                                <label for="featureTitle2">Title</label>
                                <input type="text" class="form-control" id="featureTitle2" name="featureTitle2" placeholder="Enter title" value="<?= htmlspecialchars($features[1]['name'] ?? '') ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label for="featureDescription2">Description</label>
                                <textarea class="form-control" id="featureDescription2" name="featureDescription2" rows="3" placeholder="Enter description"><?= htmlspecialchars($features[1]['description'] ?? '') ?></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="featureIcon2">Icon Name</label>
                                <input type="text" class="form-control" id="featureIcon2" name="featureIcon2" placeholder="Enter icon class (e.g., fa fa-user)" value="<?= htmlspecialchars($features[1]['icon_name'] ?? '') ?>">
                            </div>

                            <!-- Feature 3 -->
                            <h5>Feature 3</h5>
                            <div class="form-group mb-3">
                                <label for="featureTitle3">Title</label>
                                <input type="text" class="form-control" id="featureTitle3" name="featureTitle3" placeholder="Enter title" value="<?= htmlspecialchars($features[2]['name'] ?? '') ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label for="featureDescription3">Description</label>
                                <textarea class="form-control" id="featureDescription3" name="featureDescription3" rows="3" placeholder="Enter description"><?= htmlspecialchars($features[2]['description'] ?? '') ?></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="featureIcon3">Icon Name</label>
                                <input type="text" class="form-control" id="featureIcon3" name="featureIcon3" placeholder="Enter icon class (e.g., fa fa-star)" value="<?= htmlspecialchars($features[2]['icon_name'] ?? '') ?>">
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>

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
                                'fa fa-puzzle-piece', 'fa fa-rocket', 'fa fa-shield', 'fa fa-thumbs-up', 'fa fa-trophy', 'fa fa-umbrella',
                                'fa fa-bicycle', 'fa fa-book', 'fa fa-car', 'fa fa-coffee', 'fa fa-diamond', 'fa fa-fire',
                                'fa fa-flag', 'fa fa-flask', 'fa fa-map', 'fa fa-paint-brush', 'fa fa-paw', 'fa fa-plane'
                            ];
                            foreach ($icons as $icon) {
                                echo '<div class="col-sm-2 text-center mb-3">';
                                echo '<form method="POST" action="">';
                                echo '<input type="hidden" name="iconName" value="' . $icon . '">';
                                echo '<button type="submit" class="btn btn-link p-0">';
                                echo '<div class="icon-card">';
                                echo '<i class="' . $icon . ' fa-2x"></i>';
                                echo '<p>' . $icon . '</p>';
                                echo '</div>';
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

<?php
include_once './includes/__footer.php';
// Flush the output buffer and send content to browser
ob_end_flush();
?>