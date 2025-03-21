<?php
include_once './includes/__header.php';
include_once './includes/__navbar.php';
?>

<!-- Include Font Awesome CDN -->
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
        <h1 class="h3 mb-3 text-center"><strong>Features</strong></h1>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <form id="featureForm" action="#" method="post">
                            <?php for ($i = 1; $i <= 6; $i++): ?>
                                <div class="form-group">
                                    <label for="featureTitle<?php echo $i; ?>">Title <?php echo $i; ?></label>
                                    <input type="text" class="form-control" id="featureTitle<?php echo $i; ?>" name="featureTitle<?php echo $i; ?>" placeholder="Enter title">
                                </div>
                                <div class="form-group">
                                    <label for="featureIcon<?php echo $i; ?>">Icon <?php echo $i; ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="featureIcon<?php echo $i; ?>" name="featureIcon<?php echo $i; ?>" placeholder="Select an icon">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#iconModal" data-input-id="featureIcon<?php echo $i; ?>">Select Icon</button>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            <?php endfor; ?>
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Icon Selection Modal -->
<div class="modal fade" id="iconModal" tabindex="-1" role="dialog" aria-labelledby="iconModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="iconModalLabel">Select an Icon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php
                    $icons = [
                        'fa fa-home', 'fa fa-user', 'fa fa-envelope', 'fa fa-phone', 'fa fa-cog', 'fa fa-heart',
                        'fa fa-star', 'fa fa-check', 'fa fa-times', 'fa fa-search', 'fa fa-camera', 'fa fa-comments',
                        'fa fa-bell', 'fa fa-calendar', 'fa fa-cloud', 'fa fa-gift', 'fa fa-lock', 'fa fa-shopping-cart',
                        'fa fa-tag', 'fa fa-wrench', 'fa fa-leaf', 'fa fa-lightbulb', 'fa fa-music', 'fa fa-paper-plane',
                        'fa fa-puzzle-piece', 'fa fa-rocket', 'fa fa-shield', 'fa fa-thumbs-up', 'fa fa-trophy', 'fa fa-umbrella',
                        'fa fa-bicycle', 'fa fa-book', 'fa fa-car', 'fa fa-coffee', 'fa fa-diamond', 'fa fa-fire',
                        'fa fa-flag', 'fa fa-flask', 'fa fa-map', 'fa fa-paint-brush', 'fa fa-paw', 'fa fa-plane',
                        'fa fa-recycle', 'fa fa-road', 'fa fa-tree', 'fa fa-university', 'fa fa-wifi', 'fa fa-wrench'
                    ];
                    foreach ($icons as $icon) {
                        echo '<div class="col-sm-2 text-center mb-3">';
                        echo '<div class="icon-card">';
                        echo '<i class="' . $icon . ' fa-2x" data-icon="' . $icon . '"></i>';
                        echo '<p>' . $icon . '</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and dependencies for modal functionality -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        var currentInputId;

        $('#iconModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            currentInputId = button.data('input-id');
        });

        $('.icon-card i').on('click', function() {
            var iconClass = $(this).data('icon');
            $('#' + currentInputId).val(iconClass);
            $('#iconModal').modal('hide');
        });
    });
</script>

<?php include_once './includes/__footer.php'; ?>