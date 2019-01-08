<?php

require( "config.php" );
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
  case 'archive':
    archive();
    break;
  case 'viewArticle':
    viewArticle();
    break;
  case 'viewCourse':
    viewCourse();
    break;
  case 'searchTag':
	searchTag();
	break;
  case 'coursesFetch':
    coursesFetch();
	break;
  case 'booksFetch':
    booksFetch();
	break;
  default:
    homepage();
}

function archive() {
  $results = array();
  $data = Article::getList();
  $results['articles'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "Todos os Artigos | Tenda de Umbanda Pai Benedito";
  require( TEMPLATE_PATH . "/archive.php" );
}

function viewArticle() {
  if ( !isset($_GET["articleId"]) || !$_GET["articleId"] ) {
    homepage();
    return;
  }

  $results = array();
  $results['article'] = Article::getById( (int)$_GET["articleId"] );
  $results['pageTitle'] = $results['article']->title . " | Tenda de Umbanda Pai Benedito";
  require( TEMPLATE_PATH . "/viewArticle.php" );
}

function coursesFetch() {
  $results2 = array();
  $data2 = Course::getList();
  $results2['courses'] = $data2['results'];
  $results2['totalRows'] = $data2['totalRows'];
  require( TEMPLATE_PATH . "/cursos.php" );
}

function booksFetch() {
  $results4 = array();
  $data4 = Book::getList();
  $results4['book'] = $data4['results'];
  $results4['totalRows'] = $data4['totalRows'];
  require( TEMPLATE_PATH . "/leitura_livros.php" );
}

function viewCourse() {
  if ( !isset($_GET["courseID"]) || !$_GET["courseID"] ) {
    homepage();
    return;
  }

  $results = array();
  $results2 = array();
  $results2['courses'] = Course::getById( (int)$_GET["courseID"] );
  $results['pageTitle'] = $results2['courses']->courseName . " | Tenda de Umbanda Pai Benedito";
  require( TEMPLATE_PATH . "/viewCourse.php" );
}

function searchTag() {
  $results = array();
  $data = Article::getList();
  $results['articles'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  
   if ( isset( $_POST['search'] ) ) {

    // User has posted the search form: try to find the requested tags on the existing articles
	foreach ( $results['articles'] as $article )
	{
		if ( strpos(strtolower($article->tagString), strtolower($_POST['searchText'])) === false ) // The article does not have the search terms in the tagString field
		{
			$results['totalRows'] = $results['totalRows'] - 1; //Decrease totalRow count by 1
			$article->title = 'NaN'; //Change article title in the $article array to NaN to treat in the searchResults.php
		}
	}
  }

  $results['pageTitle'] = "Resultado da Busca | Tenda de Umbanda Pai Benedito";
  require( TEMPLATE_PATH . "/searchResults.php" );
}

function homepage() {
  $results = array();
  $data = Article::getList( HOMEPAGE_NUM_ARTICLES );
  $results['articles'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "Tenda de Umbanda Pai Benedito da Guiné";
  
  $results3 = array();
  $data3 = News::getList( 10 );
  $results3['news'] = $data3['results'];
  $results3['totalRows'] = $data3['totalRows'];
  require( TEMPLATE_PATH . "/homepage.php" );
}

?>
