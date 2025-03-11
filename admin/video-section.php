<?php
ob_start();
include_once './includes/__header.php';
include_once './includes/__navbar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $thumbnailUrl = null;
    $videoUrl = null;

    if (isset($_FILES['imageFile']) && $_FILES['imageFile']['error'] == UPLOAD_ERR_OK) {
        $image = $_FILES['imageFile'];
        $imagePath = '../uploads/' . basename($image['name']);
        $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
        $randomDigit = rand(1000, 9999);
        $newImageName = pathinfo($imagePath, PATHINFO_FILENAME) . '-' . $randomDigit . '.' . $imageExtension;
        $newImagePath = '../uploads/' . $newImageName;

        if (move_uploaded_file($image['tmp_name'], $newImagePath)) {
            $thumbnailUrl = $newImageName;
        } else {
            $uploadError = "Failed to upload image.";
        }
    } elseif (isset($_FILES['imageFile'])) {
        $uploadError = "Failed to upload image. Error code: " . $_FILES['imageFile']['error'];
    }

    if (isset($_POST['videoUrl']) && filter_var($_POST['videoUrl'], FILTER_VALIDATE_URL)) {
        $videoUrl = $_POST['videoUrl'];
    } else {
        $uploadError = "Invalid video URL.";
    }

    if ($thumbnailUrl && $videoUrl) {
        $existingMedia = $pdo->query("SELECT * FROM video LIMIT 1")->fetch();

        if ($existingMedia) {
            $stmt = $pdo->prepare("UPDATE video SET thumbnail_url = ?, video_url = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$thumbnailUrl, $videoUrl, $existingMedia['id']]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO video (thumbnail_url, video_url) VALUES (?, ?)");
            $stmt->execute([$thumbnailUrl, $videoUrl]);
        }

        header("Location: video-section.php");
        exit;
    } else {
        $uploadError = "Failed to upload media.";
    }
}

$existingMedia = $pdo->query("SELECT * FROM video LIMIT 1")->fetch();
?>

<style>
    .media-preview {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        height: auto;
        max-width: 100%;
        max-height: 300px;
        object-fit: cover;
        margin-top: 10px;
    }

    .video-container {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
    }

    .video-container video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        object-fit: cover;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .submit-btn {
        margin-top: 20px;
    }

    .card-body {
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
</style>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3 text-center"><strong>Upload Media</strong></h1>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <form id="mediaForm" action="video-section.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="imageFile">Choose Image</label>
                                <input type="file" class="form-control-file" id="imageFile" name="imageFile" accept="image/*" required>
                                <img id="imagePreview" src="<?= $existingMedia ? '../uploads/' . $existingMedia['thumbnail_url'] : '#' ?>" alt="Image Preview" class="media-preview" style="<?= $existingMedia ? '' : 'display: none;' ?>">
                            </div>
                            <div class="form-group">
                                <label for="videoUrl">Video URL</label>
                                <input type="url" class="form-control" id="videoUrl" name="videoUrl" placeholder="Enter video URL" value="<?= $existingMedia ? $existingMedia['video_url'] : '' ?>" required>
                                <button type="button" class="btn btn-secondary mt-2" id="loadVideoBtn">Load Video</button>
                                <div id="videoPreviewContainer" class="video-container" style="<?= $existingMedia ? '' : 'display: none;' ?>">
                                    <video id="videoPreview" controls>
                                        <source src="<?= $existingMedia ? $existingMedia['video_url'] : '#' ?>" type="video/mp4">
                                    </video>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </form>
                        <?php if (isset($uploadError)): ?>
                            <div class="alert alert-danger mt-3">
                                <?= $uploadError ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('#imageFile').change(function(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(input.files[0]);
            }
        });

        $('#loadVideoBtn').click(function() {
            const videoUrl = $('#videoUrl').val();
            if (videoUrl) {
                $('#videoPreview').attr('src', videoUrl);
                $('#videoPreviewContainer').show();
            }
        });
    });
</script>

<?php include_once './includes/__footer.php'; ?>