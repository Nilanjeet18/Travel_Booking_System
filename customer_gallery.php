<?php
// customer_gallery.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #1c1c1c;
            color: #f4dc34;
        }

        .gallery-section {
            padding: 60px 0;
        }

        .gallery-section h1 {
            text-align: center;
            margin-bottom: 40px;
            font-weight: bold;
            color: #fccb04;
        }

        .masonry {
            column-count: 3;
            column-gap: 15px;
        }

        .masonry img {
            width: 100%;
            margin-bottom: 15px;
            border: 3px solid #b4842a;
            border-radius: 12px;
            transition: 0.3s;
            break-inside: avoid; /* important to prevent cutting images in half */
        }

        .masonry img:hover {
            transform: scale(1.05);
            border-color: #fccb04;
        }

        @media (max-width: 768px) {
            .masonry {
                column-count: 2;
            }
        }

        @media (max-width: 576px) {
            .masonry {
                column-count: 1;
            }
        }
    </style>
</head>
<body>

<div class="container gallery-section">
    <h1>Our Happy Travelers</h1>
    <div class="masonry">
        <?php
        // Folder where you upload all customer images
        $folder = 'gallery/';
        
        // Supported image extensions
        $supported_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        // Scan the folder
        if (is_dir($folder)) {
            $files = scandir($folder);
            foreach ($files as $file) {
                $file_extension = pathinfo($file, PATHINFO_EXTENSION);
                if (in_array(strtolower($file_extension), $supported_types)) {
                    echo '<img src="' . $folder . $file . '" alt="Travel Image">';
                }
            }
        } else {
            echo '<p class="text-center">Gallery folder not found!</p>';
        }
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>