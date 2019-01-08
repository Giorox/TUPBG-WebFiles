<?php

/**
 * Class to handle articles
 */

class Article
{
  // Properties

  /**
  * @var int The article ID from the database
  */
  public $id = null;

  /**
  * @var int When the article was first published
  */
  public $publicationDate = null;

  /**
  * @var string Full title of the article
  */
  public $title = null;

  /**
  * @var string A short summary of the article
  */
  public $summary = null;

  /**
  * @var string The HTML content of the article
  */
  public $content = null;
  
    /**
  * @var string The filename extension of the article's full-size image (empty string means the article has no image)
  */
  public $imageExtension = "";
  
     /**
  * @var string The filename extension of the article's full-size image (empty string means the article has no image)
  */
  public $tagString = null;


  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */

  public function __construct( $data=array() ) {
    if ( isset( $data['id'] ) ) $this->id = (int) $data['id'];
    if ( isset( $data['publicationDate'] ) ) $this->publicationDate = (int) $data['publicationDate'];
    if ( isset( $data['title'] ) ) $this->title = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúãõçàâêîôûÁÉÍÓÚÂÊÎÔÛÃÕÇËÄÏÖÜ]/", "", $data['title'] );
    if ( isset( $data['summary'] ) ) $this->summary = $data['summary'];
    if ( isset( $data['content'] ) ) $this->content = $data['content'];
	if ( isset( $data['imageExtension'] ) ) $this->imageExtension = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\$ a-zA-Z0-9()]/", "", $data['imageExtension'] );
	if ( isset( $data['tagString'] ) ) $this->tagString = preg_replace( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúãõçàâêîôûÁÉÍÓÚÂÊÎÔÛÃÕÇËÄÏÖÜ]/", ";", $data['tagString']);
  }


  /**
  * Sets the object's properties using the edit form post values in the supplied array
  *
  * @param assoc The form post values
  */

  public function storeFormValues ( $params ) {

    // Store all the parameters
    $this->__construct( $params );

    // Parse and store the publication date
    if ( isset($params['publicationDate']) ) {
      $publicationDate = explode ( '-', $params['publicationDate'] );

      if ( count($publicationDate) == 3 ) {
        list ( $y, $m, $d ) = $publicationDate;
        $this->publicationDate = mktime ( 0, 0, 0, $m, $d+1, $y );
      }
    }
  }

   /**
  * Stores any image uploaded from the edit form
  *
  * @param assoc The 'image' element from the $_FILES array containing the file upload data
  */
 
  public function storeUploadedImage( $image ) {
 
    if ( $image['error'] == UPLOAD_ERR_OK )
    {
      // Does the Article object have an ID?
      if ( is_null( $this->id ) ) trigger_error( "Article::storeUploadedImage(): Attempt to upload an image for an Article object that does not have its ID property set.", E_USER_ERROR );
 
      // Delete any previous image(s) for this article
      $this->deleteImages();
 
      // Get and store the image filename extension
      $this->imageExtension = strtolower( strrchr( $image['name'], '.' ) );
 
      // Store the image
 
      $tempFilename = trim( $image['tmp_name'] ); 
 
      if ( is_uploaded_file ( $tempFilename ) ) {
        if ( !( move_uploaded_file( $tempFilename, $this->getImagePath() ) ) ) trigger_error( "Article::storeUploadedImage(): Couldn't move uploaded file.", E_USER_ERROR );
        if ( !( chmod( $this->getImagePath(), 0666 ) ) ) trigger_error( "Article::storeUploadedImage(): Couldn't set permissions on uploaded file.", E_USER_ERROR );
      }
 
      // Get the image size and type
      $attrs = getimagesize ( $this->getImagePath() );
      $imageWidth = $attrs[0];
      $imageHeight = $attrs[1];
      $imageType = $attrs[2];
 
      // Load the image into memory
      switch ( $imageType ) {
        case IMAGETYPE_GIF:
          $imageResource = imagecreatefromgif ( $this->getImagePath() );
          break;
        case IMAGETYPE_JPEG:
          $imageResource = imagecreatefromjpeg ( $this->getImagePath() );
          break;
        case IMAGETYPE_PNG:
          $imageResource = imagecreatefrompng ( $this->getImagePath() );
          break;
        default:
          trigger_error ( "Article::storeUploadedImage(): Unhandled or unknown image type ($imageType)", E_USER_ERROR );
      }
 
      $this->update();
    }
  }
 
 
  /**
  * Deletes any images associated with the article
  */
 
  public function deleteImages() {
 
    // Delete all fullsize images for this article
    foreach (glob( ARTICLE_IMAGE_PATH . "/" . IMG_TYPE_FULLSIZE . "/" . $this->id . ".*") as $filename) {
      if ( !unlink( $filename ) ) trigger_error( "Article::deleteImages(): Couldn't delete image file.", E_USER_ERROR );
    }
 
    // Remove the image filename extension from the object
    $this->imageExtension = "";
  }
 
 
  /**
  * Returns the relative path to the article's full-size image
  *
  * @param string The type of image path to retrieve. Defaults to IMG_TYPE_FULLSIZE.
  * @return string|false The image's path, or false if an image hasn't been uploaded
  */
 
  public function getImagePath( $type=IMG_TYPE_FULLSIZE ) {
    return ( $this->id && $this->imageExtension ) ? ( ARTICLE_IMAGE_PATH . "/$type/" . $this->id . $this->imageExtension ) : false;
  }
 
  

  /**
  * Returns an Article object matching the given article ID
  *
  * @param int The article ID
  * @return Article|false The article object, or false if the record was not found or there was a problem
  */

  public static function getById( $id ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM articles WHERE id = :id";
    $st = $conn->prepare( $sql );
    $st->bindValue( ":id", $id, PDO::PARAM_INT );
    $st->execute();
    $row = $st->fetch();
    $conn = null;
    if ( $row ) return new Article( $row );
  }


  /**
  * Returns all (or a range of) Article objects in the DB
  *
  * @param int Optional The number of rows to return (default=all)
  * @param string Optional column by which to order the articles (default="publicationDate DESC")
  * @return Array|false A two-element array : results => array, a list of Article objects; totalRows => Total number of articles
  */

public static function getList( $numRows=1000000, $order="publicationDate DESC" ) {

 $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

 //Your whitlelist of order bys.
 $order_whitelist = array("publicationDate DESC", "id DESC");

 // see if we have such a name, if it is not in the array then $order will be false.
        $order_check = array_search($order, $order_whitelist); 
    if ($order_check !== FALSE)
     {

     $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM articles
        ORDER BY " . $order . " LIMIT :numRows";
     $st = $conn->prepare($sql);
     $st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
     $st->execute();
     $list = array();

     while ($row = $st->fetch())
         {
         $article = new Article($row);
         $list[] = $article;
         }
     }

    // Now get the total number of articles that matched the criteria
    $sql = "SELECT FOUND_ROWS() AS totalRows";
    $totalRows = $conn->query( $sql )->fetch();
    $conn = null;
    return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
  }


  /**
  * Inserts the current Article object into the database, and sets its ID property.
  */

  public function insert() {

    // Does the Article object already have an ID?
    if ( !is_null( $this->id ) ) trigger_error ( "Article::insert(): Attempt to insert an Article object that already has its ID property set (to $this->id).", E_USER_ERROR );

    // Insert the Article
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "INSERT INTO articles ( publicationDate, title, summary, content, imageExtension, tagString ) VALUES ( FROM_UNIXTIME(:publicationDate), :title, :summary, :content, :imageExtension, :tagString )";
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":publicationDate", $this->publicationDate, PDO::PARAM_INT );
    $st->bindValue( ":title", $this->title, PDO::PARAM_STR );
    $st->bindValue( ":summary", $this->summary, PDO::PARAM_STR );
    $st->bindValue( ":content", $this->content, PDO::PARAM_STR );
	$st->bindValue( ":imageExtension", $this->imageExtension, PDO::PARAM_STR );
	$st->bindValue( ":tagString", $this->tagString, PDO::PARAM_STR );
    $st->execute();
    $this->id = $conn->lastInsertId();
    $conn = null;
  }


  /**
  * Updates the current Article object in the database.
  */

  public function update() {

    // Does the Article object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Article::update(): Attempt to update an Article object that does not have its ID property set.", E_USER_ERROR );
   
    // Update the Article
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "UPDATE articles SET publicationDate=FROM_UNIXTIME(:publicationDate), title=:title, summary=:summary, content=:content, imageExtension=:imageExtension, tagString=:tagString WHERE id = :id";
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":publicationDate", $this->publicationDate, PDO::PARAM_INT );
    $st->bindValue( ":title", $this->title, PDO::PARAM_STR );
    $st->bindValue( ":summary", $this->summary, PDO::PARAM_STR );
    $st->bindValue( ":content", $this->content, PDO::PARAM_STR );
	$st->bindValue( ":imageExtension", $this->imageExtension, PDO::PARAM_STR );
	$st->bindValue( ":tagString", $this->tagString, PDO::PARAM_STR );
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }


  /**
  * Deletes the current Article object from the database.
  */

  public function delete() {

    // Does the Article object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Article::delete(): Attempt to delete an Article object that does not have its ID property set.", E_USER_ERROR );

    // Delete the Article
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $st = $conn->prepare ( "DELETE FROM articles WHERE id = :id LIMIT 1" );
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }

}

?>
