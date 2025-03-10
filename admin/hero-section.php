<?php
// Start output buffering at the very beginning of the file
ob_start();

include_once './includes/__header.php';
include_once './includes/__navbar.php';

// Initialize alert variables
$showAlert = false;
$alertMessage = '';
$alertType = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    
    // Fetch existing hero section data
    $heroSection = $pdo->query("SELECT * FROM hero_section LIMIT 1")->fetch();
    $imageUrl = $heroSection['image_url'] ?? null;

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image'];
        $imagePath = '../uploads/' . basename($image['name']);
        $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
        $randomDigit = rand(1000, 9999);
        $newImageName = pathinfo($imagePath, PATHINFO_FILENAME) . '-' . $randomDigit . '.' . $imageExtension;
        $newImagePath = '../uploads/' . $newImageName;

        if (move_uploaded_file($image['tmp_name'], $newImagePath)) {
            $imageUrl = $newImageName;
        }
    }

    try {
        if ($heroSection) {
            $stmt = $pdo->prepare("UPDATE hero_section SET name = ?, description = ?, image_url = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$name, $description, $imageUrl, $heroSection['id']]);
            $_SESSION['alert_message'] = "Hero section updated successfully!";
            $_SESSION['alert_type'] = "success";
        } else {
            $stmt = $pdo->prepare("INSERT INTO hero_section (name, description, image_url) VALUES (?, ?, ?)");
            $stmt->execute([$name, $description, $imageUrl]);
            $_SESSION['alert_message'] = "Hero section added successfully!";
            $_SESSION['alert_type'] = "success";
        }
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

// Fetch hero section data
$heroSection = $pdo->query("SELECT * FROM hero_section LIMIT 1")->fetch();
?>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3"><strong>Hero Section</strong></h1>
        
        <!-- Alert Message (hidden by default) -->
        <?php if ($showAlert): ?>
        <div id="alertBox" class="alert alert-<?= $alertType ?>" role="alert">
            <?= htmlspecialchars($alertMessage) ?>
            <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <form id="heroForm" method="POST" enctype="multipart/form-data">
                            <div class="form-group mb-3">
                                <label for="heroName">Name</label>
                                <input type="text" class="form-control" id="heroName" name="name" placeholder="Enter name" value="<?= htmlspecialchars($heroSection['name'] ?? '') ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label for="heroDescription">Description</label>
                                <textarea class="form-control" id="heroDescription" name="description" rows="3" placeholder="Enter description"><?= htmlspecialchars($heroSection['description'] ?? '') ?></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="heroImage">Upload Image</label>
                                <input type="file" class="form-control-file" id="heroImage" name="image" accept="image/*">
                                <?php if (!empty($heroSection['image_url'])): ?>
                                    <img id="imagePreview" src="../uploads/<?= htmlspecialchars($heroSection['image_url']) ?>" class="img-fluid rounded shadow mt-2" style="max-width: 100%; height: auto;" alt="Image Preview">
                                <?php else: ?>
                                    <img id="imagePreview" src="/placeholder.svg" class="img-fluid rounded shadow mt-2" style="display: none; max-width: 100%; height: auto;" alt="Image Preview">
                                <?php endif; ?>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // Image preview functionality
    document.getElementById('heroImage').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imagePreview = document.getElementById('imagePreview');
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
</script>

<?php
include_once './includes/__footer.php';
// Flush the output buffer and send content to browser
ob_end_flush();
?>