<?php
ob_start();
include_once './includes/__header.php';
include_once './includes/__navbar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['imageFile'])) {
    $image = $_FILES['imageFile'];
    $imagePath = '../uploads/' . basename($image['name']);
    $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
    $randomDigit = rand(1000, 9999);
    $newImageName = pathinfo($imagePath, PATHINFO_FILENAME) . '-' . $randomDigit . '.' . $imageExtension;
    $newImagePath = '../uploads/' . $newImageName;

    if (move_uploaded_file($image['tmp_name'], $newImagePath)) {
        $stmt = $pdo->prepare("INSERT INTO gallery (image_name) VALUES (?)");
        $stmt->execute([$newImageName]);
        header("Location: gallery-section.php");
        exit;
    } else {
        $uploadError = "Failed to upload image.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['imageId']) && isset($_POST['imageName'])) {
    $imageId = $_POST['imageId'];
    $imageName = $_POST['imageName'];
    $filePath = '../uploads/' . $imageName;
    if (file_exists($filePath)) {
        unlink($filePath);
    }
    $stmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
    $stmt->execute([$imageId]);
    header("Location: gallery-section.php");
    exit;
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$imagesPerPage = 6;
$totalImages = $pdo->query("SELECT COUNT(*) FROM gallery")->fetchColumn();
$totalPages = ceil($totalImages / $imagesPerPage);
$startIndex = ($page - 1) * $imagesPerPage;
$images = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC LIMIT $startIndex, $imagesPerPage")->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
    .gallery-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
        cursor: pointer;
    }
    
    .gallery-image:hover {
        transform: scale(1.03);
    }
    
    .img-preview {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 100%;
        height: auto;
    }
    
    .card {
        border: none;
        background: transparent;
        margin-bottom: 20px;
    }
</style>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3 text-center"><strong>Gallery</strong></h1>
        <div class="row mb-3">
            <div class="col text-right">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addImageModal">Add New</button>
            </div>
        </div>
        <div class="row">
            <?php if (empty($images)): ?>
                <div class="col-12">
                    <div class="alert alert-warning text-center" role="alert">
                        No images found.
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($images as $image): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="../uploads/<?php echo $image['image_name']; ?>" class="gallery-image" alt="<?php echo $image['image_name']; ?>" data-toggle="modal" data-target="#deleteImageModal" data-image-id="<?php echo $image['id']; ?>" data-image-name="<?php echo $image['image_name']; ?>">
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</main>

<div class="modal fade" id="addImageModal" tabindex="-1" role="dialog" aria-labelledby="addImageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="imageForm" action="gallery-section.php" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="addImageModalLabel">Add New Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="imageFile">Choose Image</label>
                        <input type="file" class="form-control-file" id="imageFile" name="imageFile" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <img id="imagePreview" src="#" alt="Image Preview" class="img-preview" style="display: none;">
                    </div>
                    <?php if (isset($uploadError)): ?>
                        <div class="alert alert-danger">
                            <?php echo $uploadError; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteImageModal" tabindex="-1" role="dialog" aria-labelledby="deleteImageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="deleteImageForm" action="gallery-section.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteImageModalLabel">Delete Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this image?</p>
                    <img id="deleteImagePreview" src="" alt="Image to delete" class="img-thumbnail mb-3 rounded" style="max-width: 100%; height: auto;">
                    <input type="hidden" id="deleteImageId" name="imageId">
                    <input type="hidden" id="deleteImageName" name="imageName">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
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

        $('#deleteImageModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const imageId = button.data('image-id');
            const imageName = button.data('image-name');
            const imageUrl = '../uploads/' + imageName;

            const modal = $(this);
            modal.find('#deleteImageId').val(imageId);
            modal.find('#deleteImageName').val(imageName);
            modal.find('#deleteImagePreview').attr('src', imageUrl);
        });
    });
</script>

<?php include_once './includes/__footer.php'; ?>