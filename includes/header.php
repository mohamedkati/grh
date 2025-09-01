<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?php echo $pageTitle ?></title>
    <meta
        content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
        name="viewport" />
    <link
        rel="icon"
        href="<?php echo $prefix  ?>assets/img/kaiadmin/favicon.ico"
        type="image/x-icon" />

    <link href="<?= $prefix ?>assets/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Fonts and icons -->
    <script src="<?= $prefix ?>assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["<?= $prefix  ?>assets/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>
    <style>
        .mb-7{
            margin-bottom: 0.7rem !important;
        }
    </style>
    <!-- CSS Files -->
    <link rel="stylesheet" href="<?= $prefix  ?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= $prefix  ?>assets/css/plugins.min.css" />
    <link rel="stylesheet" href="<?= $prefix  ?>assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="<?= $prefix  ?>assets/css/demo.css" />
</head>

<body>