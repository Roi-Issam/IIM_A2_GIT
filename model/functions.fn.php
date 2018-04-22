<<<<<<< HEAD
<?php 
/*******************************************************************
SUMMARY
	1!FUNCTIONS
		1.1!userRegistration
		1.2!userConnection
		1.3!listMusics
		1.4!selectMusic
		1.5!addMusic
		1.6!updateMusic
		1.7!deleteMusic
		1.8!isEmailAvailable
		1.9!isUsernameAvailable
		2.0!isMusicOwner
		2.1!updateProfilPicture	

********************************************************************/

/**************************************************
 * 1!FUNCTIONS
 *************************************************
 * @param PDO $db
 * @param $username
 * @param $email
 * @param $password
 */
		

	/*1.1!userRegistration
		return :
			true for registration OK
			false for fail
		$db -> 				database object
		$username -> 		field value : username
		$email -> 			field value : email
		$password -> 		field value : password
	*/
	function userRegistration(PDO $db, $username, $email, $password){
		$sql = "INSERT INTO users
				  SET
				  username = :username,
				  email = :email,
				  password = :password
				  ";


		$req = $db->prepare($sql);
		$req->execute(array(
			':username' => $username,
			':email' => $email,
			':password' => $password,
		));
		

	}


	/*1.2!userConnection
		return :
			true for connection OK
			false for fail
		$db -> 				database object
		$email -> 			field value : email
		$password -> 		field value : password
	*/
	function userConnection(PDO $db, $email, $password){
		if(!empty($email) && !empty($password)){
			//Requête SQL
			$sql = "SELECT * FROM users WHERE email = :email AND password = :password LIMIT 1";

			$req = $db->prepare($sql);
			$req->execute(array(
				':email' => $email,
				':password' => $password
			));

			$result = $req->fetch(PDO::FETCH_ASSOC);

			//Si le fetch réussi, alors un résultat a été retourné donc le couple email / password est correct
			if($result == true){
				
				//on définit la SESSION
				$_SESSION['id'] = $result['id'];
				$_SESSION['username'] = $result['username'];
				$_SESSION['email'] = $result['email'];
				$_SESSION['created_at'] = $result['created_at'];
				$_SESSION['image'] = $result['picture'];

				return true;
			}else{
				return false;
			}
		}else{

			return false;
		}
	}

	/*1.3!listMusics
		return :
			array of results
		$db -> 				database object
	*/
	function listMusics(PDO $db){
		$sql = "SELECT musics.*, users.id AS user_id, users.username, users.picture FROM musics LEFT JOIN users ON musics.user_id = users.id ORDER BY musics.created_at DESC";

		$req = $db->prepare($sql);
		$req->execute();

		$results = $req->fetchAll(PDO::FETCH_ASSOC);

		return $results;
	}

	/*1.4!selectMusic
		return :
			array
		$db -> 				database object
		$music_id -> 		value : music_id
	*/
	function selectMusic(PDO $db, $music_id){
		$sql = "SELECT * FROM musics WHERE id = :id";

		$req = $db->prepare($sql);
		$req->execute(array(
			':id' => $music_id
		));

		$result = $req->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	/*1.5!addMusic
		return :
			true if music added
		$db -> 			database object
		$user_id -> 	current user_id
		$title -> 		field value : title
		$file -> 		file object : music
	*/
	function addMusic(PDO $db, $user_id, $title, $file){
		$sql = "
			INSERT INTO
				musics
			SET
				user_id = :user_id,
				title = :title,
				file = :file
		";

		$req = $db->prepare($sql);
		$req->execute(array(
			':user_id' => $user_id,
			':title' => $title,
			':file' => $file,
		));

		return true;
	}

	/*1.6!updateMusic
		return :
			true if music updated
			false if not updated
		$db -> 			database object
		$music_id -> 	music id
		$title -> 		field value : title
		$user_id -> 	current user id
	*/
	function updateMusic(PDO $db, $music_id, $title, $user_id){
		$music_owner = isMusicOwner($db, $music_id, $user_id);

		if($music_owner == true){
			$sql = "
				UPDATE
					musics
				SET
		            title = :title
				WHERE
					 id = :id
			";

			$req = $db->prepare($sql);
			$req->execute(array(
				':title' => $title,
				':id' => $music_id
			));

			return true;
		}
		else{
			return false;
		}
	}

	/*1.7!deleteMusic
		return :
			true if music deleted
			false if not deleted
		$db -> 			database object
		$user_id -> 	current user_id
		$title -> 		field value : title
		$music_id -> 	music id
	*/
	function deleteMusic(PDO $db, $music_id, $user_id){
		$music_owner = isMusicOwner($db, $music_id, $user_id);

		if($music_owner == true){
			$sql = "DELETE FROM musics WHERE id = :id";

			$req = $db->prepare($sql);
			$req->execute(array(':id' => $music_id));

			return true;
		}
		else{
			return false;
		}
	}

	/*1.8!isEmailAvailable*/
	function isEmailAvailable(PDO $db, $email){
		$sql = "SELECT id FROM users WHERE email = :email LIMIT 1";

		$req = $db->prepare($sql);
		$req->execute(array(':email' => $email));

		$result = $req->fetch(PDO::FETCH_ASSOC);

		if(!empty($result)) return false;
		else return true;
	}

	/*1.9!isUsernameAvailable*/
	function isUsernameAvailable(PDO $db, $username){
		$sql = "SELECT id FROM users WHERE username = :username LIMIT 1";

		$req = $db->prepare($sql);
		$req->execute(array(':username' => $username));

		$result = $req->fetch(PDO::FETCH_ASSOC);

		if(!empty($result)) return false;
		else return true;
	}

	/*2.0!isMusicOwner*/
	function isMusicOwner(PDO $db, $music_id, $user_id){
		$sql = "
			SELECT
				COUNT(id) AS is_owner
			FROM
				musics
			WHERE
				id = :music_id
			AND
				user_id = :user_id
		";

		$req = $db->prepare($sql);
		$req->execute(array(
			':music_id' => $music_id,
			':user_id' => $user_id
		));

		$result = $req->fetch();

		if($result['is_owner'] > 0){
			return true;
		}
		else{
			return false;
		}
	}	

	/*2.1!updateProfilPicture*/
	function updateProfilPicture(PDO $db, $pic, $user_id){
		$sql = "
								UPDATE
									users
								SET
						            picture = :pic
								WHERE
									 id = :id
							";

		$req = $db->prepare($sql);
		$req->execute(array(
			':pic' => $pic,
			':id' => $user_id
		));
	}


	function comment(PDO $db, $user_id, $text, $music_id){
        $sql = "
			INSERT INTO
				comments
			SET
				user_id = :user_id,
				text = :text,
				music_id = :music_id
		";

        $req = $db->prepare($sql);
        $req->execute(array(
            ':user_id' => $user_id,
            ':text' => $text,
            ':music_id' => $music_id,
        ));

        return true;
    }


    function listComment(PDO $db, $music_id){
       // $sql = "SELECT * FROM comments INNER JOIN musics ON comments.music_id = musics.id";
        //$sql = "SELECT comments.*, musics.id AS music_id FROM comments INNER JOIN musics ON comments.music_id = musics.id ORDER BY comments.created_at DESC";

        $sql = "SELECT comments.*, users.id AS user_id, users.username FROM comments INNER JOIN users ON comments.user_id = users.id AND comments.music_id = :musicsid ORDER BY comments.created_at DESC";



        $req = $db->prepare($sql);
        $req->execute(array(
            ':musicsid' => $music_id
        ));


        $results = $req->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }
=======
<?php 
/*******************************************************************
SUMMARY
	1!FUNCTIONS
		1.1!userRegistration
		1.2!userConnection
		1.3!listMusics
		1.4!selectMusic
		1.5!addMusic
		1.6!updateMusic
		1.7!deleteMusic
		1.8!isEmailAvailable
		1.9!isUsernameAvailable
		2.0!isMusicOwner
		2.1!updateProfilPicture	

********************************************************************/

/**************************************************
					1!FUNCTIONS
**************************************************/
		

	/*1.1!userRegistration
		return :
			true for registration OK
			false for fail
		$db -> 				database object
		$username -> 		field value : username
		$email -> 			field value : email
		$password -> 		field value : password
	*/
	function userRegistration(PDO $db, $username, $email, $password){
		$sql = "INSERT INTO users
				  SET
				  username = :username,
				  email = :email,
				  password = :password";


		$req = $db->prepare($sql);
		$req->execute(array(
			':username' => $username,
			':email' => $email,
			':password' => $password,
		));
		

	}


	/*1.2!userConnection
		return :
			true for connection OK
			false for fail
		$db -> 				database object
		$email -> 			field value : email
		$password -> 		field value : password
	*/
function userConnection(PDO $db, $email, $password)
{
    if (!empty($email) && !empty($password)) {
        //Requête SQL
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";

        $req = $db->prepare($sql);
        $req->execute(array(
            ':email' => $email,
        ));

        $data = $req->fetch(PDO::FETCH_ASSOC);
        $passwordHash = $data['password'];
        $result = password_verify($password, $passwordHash);

        //Si le fetch réussi, alors un résultat a été retourné donc le couple email / password est correct
        if ($result == true) {

            //on définit la SESSION
            $_SESSION['id'] = $result['id'];
            $_SESSION['username'] = $result['username'];
            $_SESSION['email'] = $result['email'];
            $_SESSION['created_at'] = $result['created_at'];
            $_SESSION['image'] = $result['picture'];

            return true;
        } else {
            return false;
        }
    } else {

        return false;
    }
}

	/*1.3!listMusics
		return :
			array of results
		$db -> 				database object
	*/
	function listMusics(PDO $db){
		$sql = "SELECT musics.*, users.id AS user_id, users.username, users.picture FROM musics LEFT JOIN users ON musics.user_id = users.id ORDER BY musics.created_at DESC";

		$req = $db->prepare($sql);
		$req->execute();

		$results = $req->fetchAll(PDO::FETCH_ASSOC);

		return $results;
	}

	/*1.4!selectMusic
		return :
			array
		$db -> 				database object
		$music_id -> 		value : music_id
	*/
	function selectMusic(PDO $db, $music_id){
		$sql = "SELECT * FROM musics WHERE id = :id";

		$req = $db->prepare($sql);
		$req->execute(array(
			':id' => $music_id
		));

		$result = $req->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	/*1.5!addMusic
		return :
			true if music added
		$db -> 			database object
		$user_id -> 	current user_id
		$title -> 		field value : title
		$file -> 		file object : music
	*/
	function addMusic(PDO $db, $user_id, $title, $file){
		$sql = "
			INSERT INTO
				musics
			SET
				user_id = :user_id,
				title = :title,
				file = :file
		";

		$req = $db->prepare($sql);
		$req->execute(array(
			':user_id' => $user_id,
			':title' => $title,
			':file' => $file,
		));

		return true;
	}

	/*1.6!updateMusic
		return :
			true if music updated
			false if not updated
		$db -> 			database object
		$music_id -> 	music id
		$title -> 		field value : title
		$user_id -> 	current user id
	*/
	function updateMusic(PDO $db, $music_id, $title, $user_id){
		$music_owner = isMusicOwner($db, $music_id, $user_id);

		if($music_owner == true){
			$sql = "
				UPDATE
					musics
				SET
		            title = :title
				WHERE
					 id = :id
			";

			$req = $db->prepare($sql);
			$req->execute(array(
				':title' => $title,
				':id' => $music_id
			));

			return true;
		}
		else{
			return false;
		}
	}

	/*1.7!deleteMusic
		return :
			true if music deleted
			false if not deleted
		$db -> 			database object
		$user_id -> 	current user_id
		$title -> 		field value : title
		$music_id -> 	music id
	*/
	function deleteMusic(PDO $db, $music_id, $user_id){
		$music_owner = isMusicOwner($db, $music_id, $user_id);

		if($music_owner == true){
			$sql = "DELETE FROM musics WHERE id = :id";

			$req = $db->prepare($sql);
			$req->execute(array(':id' => $music_id));

			return true;
		}
		else{
			return false;
		}
	}

	/*1.8!isEmailAvailable*/
	function isEmailAvailable(PDO $db, $email){
		$sql = "SELECT id FROM users WHERE email = :email LIMIT 1";

		$req = $db->prepare($sql);
		$req->execute(array(':email' => $email));

		$result = $req->fetch(PDO::FETCH_ASSOC);

		if(!empty($result)) return false;
		else return true;
	}

	/*1.9!isUsernameAvailable*/
	function isUsernameAvailable(PDO $db, $username){
		$sql = "SELECT id FROM users WHERE username = :username LIMIT 1";

		$req = $db->prepare($sql);
		$req->execute(array(':username' => $username));

		$result = $req->fetch(PDO::FETCH_ASSOC);

		if(!empty($result)) return false;
		else return true;
	}

	/*2.0!isMusicOwner*/
	function isMusicOwner(PDO $db, $music_id, $user_id){
		$sql = "
			SELECT
				COUNT(id) AS is_owner
			FROM
				musics
			WHERE
				id = :music_id
			AND
				user_id = :user_id
		";

		$req = $db->prepare($sql);
		$req->execute(array(
			':music_id' => $music_id,
			':user_id' => $user_id
		));

		$result = $req->fetch();

		if($result['is_owner'] > 0){
			return true;
		}
		else{
			return false;
		}
	}	

	/*2.1!updateProfilPicture*/
	function updateProfilPicture(PDO $db, $pic, $user_id){
		$sql = "
								UPDATE
									users
								SET
						            picture = :pic
								WHERE
									 id = :id
							";

		$req = $db->prepare($sql);
		$req->execute(array(
			':pic' => $pic,
			':id' => $user_id
		));
	}
>>>>>>> origin/hachage
