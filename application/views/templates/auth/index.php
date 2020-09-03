<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="ArchitectUI HTML Bootstrap 4 Dashboard Template">
    <?= $meta_tag ?>

    <title><?= $site_title ?></title>
    <meta name="msapplication-tap-highlight" content="no">

    <link href="<?= base_url('assets/admin/mainv2.css') ?>" rel="stylesheet">
    <link href="<?= base_url() ?>assets/sweetalert2/sweetalert2.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?= base_url() ?>assets/favicon/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="<?= base_url() ?>assets/favicon/favicon-16x16.png" sizes="16x16">
    <?= $styles ?>

    <script type="text/javascript" src="<?= base_url('assets/admin/assets/scripts/jquery-3.4.1.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/admin/assets/scripts/main.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/sweetalert2/sweetalert2.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/syam.js') ?>"></script>
    <?= $scripts_header ?>
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow">
        <div class="app-container">
            <div class="h-100 bg-plum-plate bg-animation">
                <div class="d-flex h-100 justify-content-center align-items-center">
                    <div class="mx-auto app-login-box col-md-8">
                        <!-- <div class="app-logo-inverse mx-auto mb-3"></div> -->
                        <div class="modal-dialog w-100 mx-auto">
                            <div class="modal-content">
                                <?= $content; ?>
                            </div>
                        </div>
                        <div class="text-center text-white opacity-8 mt-3">Copyright © Daily Service UID Banten <?= date('Y') ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>