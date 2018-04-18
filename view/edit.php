<body>
	<?php include '_topbar.php'; ?>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div id="musicfeed">
					<h1><i class="fa fa-pencil"></i> Editer la musique</h1>
					<div class="block animated fadeInDown">
						<div class="row">
							<div class="col-xs-10 col-sm-10 col-md-11 col-lg-11">
								<b class="title"><?php echo $music['title']; ?></b>
								<form action="#" method="POST">
									<div class="form-group">
										<label for="title">Titre</label>
										<input type="text" name="title" class="form-control" value="<?php echo $music['title']; ?>"/>
									</div>
									<p class="clearfix"><button type="submit" class="valid pull-right"><i class="fa fa-check"></i> Valider</button></p>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
