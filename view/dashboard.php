<body>
	<?php include '_topbar.php'; ?>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div id="musicfeed">
					<h1><i class="fa fa-clock-o"></i> Sound Feed</h1>
					<?php foreach($musics as $music){ ?>
						<div class="music animated fadeInDown" data-src="<?php echo $music['file']; ?>">
							<div class="row">
								<div class="col-xs-2 col-sm-2 col-md-1 col-lg-1">
									<div class="author">
										<?php 
											$sql = "SELECT picture FROM users WHERE id = :id LIMIT 1";
											$req = $db->prepare($sql);
											$req->execute(array(
												':id' => $music['user_id']
											));
											$result = $req->fetch(PDO::FETCH_ASSOC);
											if(!empty($result)){
												echo '<img class="" src="'.$result['picture'].'" alt="">';
											}
											else{
												echo '<img src="view/profil_pic/undefined.jpg" alt=""></a>';
											}
										?>
									</div>
								</div>
								<div class="col-xs-10 col-sm-10 col-md-11 col-lg-11">
									<div class="pull-right">
										<ul class="list-inline actionicon">
										<?php if($music['user_id'] == $_SESSION['id']){
											echo '<li><a href="edit.php?id='.$music['id'].'&&user_id='.$music['user_id'].'"><i class="fa fa-pencil"></i></a></li>';
											echo '<li><a href="delete.php?id='.$music['id'].'"><i class="fa fa-times"></i></a></li>';
										} ?>
										</ul>
									</div>
									<b class="username">Posté par <?php echo $music['username']; ?></b>
									<h3 class="title">
										<?php echo $music['title']; ?>
									</h3>
									<p class="clearfix">
										<small class="date pull-right"><i class="fa fa-clock-o"></i> <?php echo $music['created_at']; ?></small>
									</p>
								</div>
							</div>
                            <div>
                                <form method="post" action="dashboard.php">
                                    <div class="form-group">
                                        <label for="name">Commentaire</label>
                                        <textarea name="subject" class="form-control" rows="4" cols="50"> </textarea>
                                    </div>
                                    <input type="hidden" name="music_id" value="<?php echo $music['id'] ?>">
                                <button type="submit" class="btn btn-default">Commenter</button>
                            </form>
                            </div>
                            <div>
                                <ul class="list-group">
                                    <?php $comments = listComment($db, $music['id']); ?>
                                    <?php foreach($comments as $comment){ ?>
                                        <li class="list-group-item"><?php echo $comment['text'] ?></li>
                                    <?php } ?>
                                </ul>
                            </div>
						</div>
					<?php } ?>
                    </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>


