<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('templates/frontend/header') ?>

<body>
	<div class="container-scroller">
		<nav class="navbar horizontal-layout col-lg-12 col-12 p-0">
			<?php $this->load->view('templates/frontend/navtop') ?>
			<?php $this->load->view('templates/frontend/navbottom') ?>
        </nav>
		
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
			<div class="main-panel">
				<div class="content-wrapper">
					<!-- Content -->
                    <div id="content">
						<?php echo $content; ?>
                    </div>
                    <!-- End Content -->
                </div>
				<?php $this->load->view('templates/frontend/footer') ?>
            </div>
        </div>
    </div>
</body>
</html>