<body>
	<?php include '_topbar.php'; ?>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div id="musicfeed">
					<h1><i class="fa fa-pencil"></i> Editer votre image de profil</h1>
					<div class="block animated fadeInDown">
						<div class="row">
							<div class="col-xs-2 col-sm-2 col-md-1 col-lg-1">
								<div class="author">
									<?php
									if(isset($_SESSION['image']) && !empty($_SESSION['image'])){
										echo '<a href="edit_image.php"><img src="'.$_SESSION['image'].'" alt=""></a>';
									}
									else{
										echo '<a href="edit_image.php"><img src="view/profil_pic/undefined.jpg" alt=""></a>';
									}
									?>
								</div>
							</div>
							<div class="col-xs-10 col-sm-10 col-md-11 col-lg-11">

								<?php
								if(isset($error) && !empty($error)){
									echo '<div class="alert alert-danger alert-dismissable">';
									  echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
									 echo  $error;
									echo '</div>';
								}
								?>

								<b class="username"><?php echo $_SESSION['username']; ?></b>
								<p>
									<br>
									Extensions autorisées : .jpg, .png et .gif
								</p>
								<form action="edit_image.php" method="POST" enctype="multipart/form-data">
									<input type="file" name="image">
									<p class="clearfix"><button type="submit" class="valid pull-right"><i class="fa fa-check"></i> Valider</button></p>
								</form>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
include '_footer.php';
?>