<?php

require( "config.php" );
session_start();
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
$username = isset( $_SESSION['username'] ) ? $_SESSION['username'] : "";

if ( $action != "login" && $action != "logout" && !$username ) {
  login();
  exit;
}

switch ( $action ) {
  case 'login':
    login();
    break;
  case 'logout':
    logout();
    break;
  case 'newArticle':
    newArticle();
    break;
  case 'editArticle':
    editArticle();
    break;
  case 'deleteArticle':
    deleteArticle();
    break;
  case 'editPhotoGallery':
	editPhotoGallery();
	break;
  case 'newCourses':
	newCourses();
	break;
  case 'deleteCourses':
	deleteCourses();
	break;
  case 'editCourses':
	editCourses();
	break;
  case 'newNews':
	newNews();
	break;
  case 'deleteNews':
	deleteNews();
	break;
  case 'editNews':
	editNews();
	break;
  case 'newBooks':
	newBooks();
	break;
  case 'deleteBooks':
	deleteBooks();
	break;
  case 'editBooks':
	editBooks();
	break;
  default:
    listArticles();
}


function login() {

  $results = array();
  $results['pageTitle'] = "Admin Login | Tenda de Umbanda Pai Benedito";

  if ( isset( $_POST['login'] ) ) {

    // User has posted the login form: attempt to log the user in

    if ( $_POST['username'] == ADMIN_USERNAME && $_POST['password'] == ADMIN_PASSWORD ) {

      // Login successful: Create a session with access privilege set to 1 (ALL FUNCTIONS) and redirect to the admin homepage
      $_SESSION['username'] = ADMIN_USERNAME;
	  $_SESSION['accesslevel'] = 1;
      header( "Location: admin.php" );

    } elseif ( $_POST['username'] == ADMIN_USERNAME_2 && $_POST['password'] == ADMIN_PASSWORD_2 ){
		
	  // Login successful: Create a session with access privilege set to 2 (ONLY ARTICLE FUNCTIONS) and redirect to the admin homepage
      $_SESSION['username'] = ADMIN_USERNAME_2;
	  $_SESSION['accesslevel'] = 2;
      header( "Location: admin.php" );
	} else {

      // Login failed: display an error message to the user
      $results['errorMessage'] = "Senha ou usuário incorreto. Tente novamente.";
      require( TEMPLATE_PATH . "/admin/loginForm.php" );
    }

  } else {

    // User has not posted the login form yet: display the form
    require( TEMPLATE_PATH . "/admin/loginForm.php" );
  }

}


function logout() {
  unset( $_SESSION['username'] );
  header( "Location: admin.php" );
}


function newArticle() {

  $results = array();
  $results['pageTitle'] = "Novo Artigo | Tenda de Umbanda Pai Benedito";
  $results['formAction'] = "newArticle";

  if ( isset( $_POST['saveChanges'] ) ) {

    // User has posted the article edit form: save the new article
    $article = new Article;
    $article->storeFormValues( $_POST );
    $article->insert();
	if ( isset( $_FILES['image'] ) ) $article->storeUploadedImage( $_FILES['image'] );
    header( "Location: admin.php?status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    // User has cancelled their edits: return to the article list
    header( "Location: admin.php" );
  } else {

    // User has not posted the article edit form yet: display the form
    $results['article'] = new Article;
    require( TEMPLATE_PATH . "/admin/editArticle.php" );
  }

}


function editArticle() {

  $results = array();
  $results['pageTitle'] = "Editar Artigo | Tenda de Umbanda Pai Benedito";
  $results['formAction'] = "editArticle";

  if ( isset( $_POST['saveChanges'] ) ) {

    // User has posted the article edit form: save the article changes

    if ( !$article = Article::getById( (int)$_POST['articleId'] ) ) {
      header( "Location: admin.php?error=articleNotFound" );
      return;
    }

    $article->storeFormValues( $_POST );
	if ( isset($_POST['deleteImage']) && $_POST['deleteImage'] == "yes" ) $article->deleteImages();
    $article->update();
	if ( isset( $_FILES['image'] ) ) $article->storeUploadedImage( $_FILES['image'] );
    header( "Location: admin.php?status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    // User has cancelled their edits: return to the article list
    header( "Location: admin.php" );
  } else {

    // User has not posted the article edit form yet: display the form
    $results['article'] = Article::getById( (int)$_GET['articleId'] );
    require( TEMPLATE_PATH . "/admin/editArticle.php" );
  }

}

function newCourses() {
  $results2 = array();
  $results['pageTitle'] = "Novo Curso | Tenda de Umbanda Pai Benedito";
  $results2['formAction'] = "newCourses";

  if ( isset( $_POST['saveChanges'] ) ) {

    // User has posted the article edit form: save the new article
    $course = new Course;
	$course->courseID = null;
    $course->storeFormValues( $_POST );
    $course->insert();
    header( "Location: admin.php?status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    // User has cancelled their edits: return to the article list
    header( "Location: admin.php" );
  } else {

    // User has not posted the article edit form yet: display the form
    $results2['course'] = new Course;
    require( TEMPLATE_PATH . "/admin/editCourses.php" );
}
}

function editCourses() {
  $results2 = array();
  $results['pageTitle'] = "Editar Curso | Tenda de Umbanda Pai Benedito";
  $results2['formAction'] = "editCourses";

  if ( isset( $_POST['saveChanges'] ) ) {

    // User has posted the course edit form: save the article changes

    if ( !$course = Course::getById( (int)$_POST['courseID'] ) ) {
      header( "Location: admin.php?error=courseNotFound" );
      return;
    }

    $course->storeFormValues( $_POST );
    $course->update();
    header( "Location: admin.php?status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    // User has cancelled their edits: return to the article list
    header( "Location: admin.php" );
  } else {

    // User has not posted the article edit form yet: display the form
    $results2['course'] = Course::getById( (int)$_GET['courseID'] );
    require( TEMPLATE_PATH . "/admin/editCourses.php" );
  }
}

function deleteCourses() {
	if ( !$course = Course::getById( (int)$_GET['courseID'] ) ) {
    header( "Location: admin.php?error=courseNotFound" );
    return;
  }

  $course->delete();
  header( "Location: admin.php?status=courseDeleted" );
}

function editPhotoGallery() {
	$results['pageTitle'] = "Editar Carrossel de Fotos | Tenda de Umbanda Pai Benedito";
	$results['formAction'] = "editPhotoGallery";
	// Check if image file is a actual image or fake image
	if(isset($_POST["saveChanges"])) {
		$target_dir = "images/photogallery/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}

		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 5000000000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				header( "Location: admin.php?status=changesSaved" );
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
	} elseif ( isset( $_POST['cancel'] ) ) {

    // User has cancelled their edits: return to the article list
    header( "Location: admin.php" );
  } elseif ( isset( $_POST['deleteImg'] ) ){
	unlink($_POST['URLimagem']);
	header( "Location: admin.php?status=changesSaved" );
  }else {

    // User has not posted the article edit form yet: display the form
    require( TEMPLATE_PATH . "/admin/editGallery.php" );
  }
}

function deleteArticle() {

  if ( !$article = Article::getById( (int)$_GET['articleId'] ) ) {
    header( "Location: admin.php?error=articleNotFound" );
    return;
  }

  $article->deleteImages();
  $article->delete();
    $drop_query = "ALTER TABLE articles DROP COLUMN id;";
  $setincrement_query = "ALTER TABLE articles AUTO_INCREMENT = 1;";
  $reincludecolumn_query = "ALTER TABLE articles ADD id int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;";
  $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
  
  $st = $conn->prepare ($drop_query);
  $st->execute();
  
  $st = $conn->prepare ( $setincrement_query );
  $st->execute();
  
  $st = $conn->prepare ( $reincludecolumn_query );
  $st->execute();
  
  header( "Location: admin.php?status=articleDeleted" );
}


function listArticles() {
  $results = array();
  $data = Article::getList();
  $results['articles'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "Dashboard do Administrador | Tenda de Umbanda Pai Benedito";
  
  $results2 = array();
  $data2 = Course::getList();
  $results2['courses'] = $data2['results'];
  $results2['totalRows'] = $data2['totalRows'];
  
  $results3 = array();
  $data3 = News::getList();
  $results3['news'] = $data3['results'];
  $results3['totalRows'] = $data3['totalRows'];
  
  $results4 = array();
  $data4 = Book::getList();
  $results4['book'] = $data4['results'];
  $results4['totalRows'] = $data4['totalRows'];

  if ( isset( $_GET['error'] ) ) {
    if ( $_GET['error'] == "articleNotFound" ) $results['errorMessage'] = "Erro: Artigo não encontrado.";
	if ( $_GET['error'] == "courseNotFound" ) $results['errorMessage'] = "Erro: Curso não encontrado.";
	if ( $_GET['error'] == "newsNotFound" ) $results['errorMessage'] = "Erro: Notícia não encontrada.";
	if ( $_GET['error'] == "bookNotFound" ) $results['errorMessage'] = "Erro: Livro não encontrado.";
  }

  if ( isset( $_GET['status'] ) ) {
    if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Suas mudanças foram salvas.";
    if ( $_GET['status'] == "articleDeleted" ) $results['statusMessage'] = "Artigo excluido.";
    if ( $_GET['status'] == "courseDeleted" ) $results['statusMessage'] = "Curso excluido.";
	if ( $_GET['status'] == "newsDeleted" ) $results['statusMessage'] = "Notícia excluida.";
	if ( $_GET['status'] == "bookDeleted" ) $results['statusMessage'] = "Livro excluido.";
  }

  require( TEMPLATE_PATH . "/admin/listArticles.php" );
}

function newNews() {

  $results3 = array();
  $results['pageTitle'] = "Nova Notícia | Tenda de Umbanda Pai Benedito";
  $results3['formAction'] = "newNews";

  if ( isset( $_POST['saveChanges'] ) ) {

    // User has posted the news edit form: save the new news
    $news = new News;
    $news->storeFormValues( $_POST );
    $news->insert();
	if ( isset( $_FILES['image'] ) ) $news->storeUploadedImage( $_FILES['image'] );
    header( "Location: admin.php?status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    // User has cancelled their edits: return to the news list
    header( "Location: admin.php" );
  } else {

    // User has not posted the news edit form yet: display the form
    $results3['news'] = new News;
    require( TEMPLATE_PATH . "/admin/editNews.php" );
  }

}


function editNews() {

  $results3 = array();
  $results['pageTitle'] = "Editar Notícia | Tenda de Umbanda Pai Benedito";
  $results3['formAction'] = "editNews";

  if ( isset( $_POST['saveChanges'] ) ) {

    // User has posted the news edit form: save the news changes

    if ( !$news = News::getById( (int)$_POST['newsID'] ) ) {
      header( "Location: admin.php?error=newsNotFound" );
      return;
    }

    $news->storeFormValues( $_POST );
	if ( isset($_POST['deleteImage']) && $_POST['deleteImage'] == "yes" ) $news->deleteImages();
    $news->update();
	if ( isset( $_FILES['image'] ) ) $news->storeUploadedImage( $_FILES['image'] );
    header( "Location: admin.php?status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    // User has cancelled their edits: return to the news list
    header( "Location: admin.php" );
  } else {

    // User has not posted the news edit form yet: display the form
    $results3['news'] = News::getById( (int)$_GET['newsID'] );
    require( TEMPLATE_PATH . "/admin/editNews.php" );
  }

}

function deleteNews() {

  if ( !$news = News::getById( (int)$_GET['newsID'] ) ) {
    header( "Location: admin.php?error=newsNotFound" );
    return;
  }

  $news->deleteImages();
  $news->delete();
  header( "Location: admin.php?status=newsDeleted" );
}

function newBooks() {
  $results4 = array();
  $results['pageTitle'] = "Novo Livro | Tenda de Umbanda Pai Benedito";
  $results4['formAction'] = "newBooks";

  if ( isset( $_POST['saveChanges'] ) ) {

    // User has posted the book edit form: save the new book
    $book = new Book;
	$book->bookID = null;
    $book->storeFormValues( $_POST );
    $book->insert();
    header( "Location: admin.php?status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    // User has cancelled their edits: return to the book list
    header( "Location: admin.php" );
  } else {

    // User has not posted the book edit form yet: display the form
    $results4['book'] = new Book;
    require( TEMPLATE_PATH . "/admin/editBooks.php" );
}
}

function editBooks() {
  $results4 = array();
  $results['pageTitle'] = "Editar Livro | Tenda de Umbanda Pai Benedito";
  $results4['formAction'] = "editBooks";

  if ( isset( $_POST['saveChanges'] ) ) {

    // User has posted the book edit form: save the book changes

    if ( !$book = Book::getById( (int)$_POST['bookID'] ) ) {
      header( "Location: admin.php?error=bookNotFound" );
      return;
    }

    $book->storeFormValues( $_POST );
    $book->update();
    header( "Location: admin.php?status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    // User has cancelled their edits: return to the book list
    header( "Location: admin.php" );
  } else {

    // User has not posted the book edit form yet: display the form
    $results4['book'] = Book::getById( (int)$_GET['bookID'] );
    require( TEMPLATE_PATH . "/admin/editBooks.php" );
  }
}

function deleteBooks() {
	if ( !$book = Book::getById( (int)$_GET['bookID'] ) ) {
    header( "Location: admin.php?error=bookNotFound" );
    return;
  }

  $book->delete();
  header( "Location: admin.php?status=bookDeleted" );
}

?>
