<?php

/**
 * Class to handle news
 */

class News
{
  // Properties

  /**
  * @var int The news ID from the database
  */
  public $newsID = null;

  /**
  * @var string The filename extension of the news's full-size image (empty string means the article has no image)
  */
  public $imageExtension_news = "";
  
  /**
  * @var string The HTML content of the news story
  */
  public $content = null;

  /**
  * @var string The title of the news story
  */
  public $title = null;


  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */

  public function __construct( $data=array() ) {
    if ( isset( $data['newsID'] ) ) $this->newsID = (int) $data['newsID'];
	if ( isset( $data['imageExtension_news'] ) ) $this->imageExtension_news = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\$ a-zA-Z0-9()]/", "", $data['imageExtension_news'] );
    if ( isset( $data['content'] ) ) $this->content = $data['content'];
	if ( isset( $data['title'] ) ) $this->title = $data['title'];
  }


  /**
  * Sets the object's properties using the edit form post values in the supplied array
  *
  * @param assoc The form post values
  */

  public function storeFormValues ( $params ) {

    // Store all the parameters
    $this->__construct( $params );
  }

   /**
  * Stores any image uploaded from the edit form
  *
  * @param assoc The 'image' element from the $_FILES array containing the file upload data
  */
 
  public function storeUploadedImage( $image ) {
 
    if ( $image['error'] == UPLOAD_ERR_OK )
    {
      // Does the News object have an ID?
      if ( is_null( $this->newsID ) ) trigger_error( "New::storeUploadedImage(): Attempt to upload an image for an New object that does not have its newsID property set.", E_USER_ERROR );
 
      // Delete any previous image(s) for this article
      $this->deleteImages();
 
      // Get and store the image filename extension
      $this->imageExtension_news = strtolower( strrchr( $image['name'], '.' ) );
 
      // Store the image
 
      $tempFilename = trim( $image['tmp_name'] ); 
 
      if ( is_uploaded_file ( $tempFilename ) ) {
        if ( !( move_uploaded_file( $tempFilename, $this->getImagePath() ) ) ) trigger_error( "New::storeUploadedImage(): Couldn't move uploaded file.", E_USER_ERROR );
        if ( !( chmod( $this->getImagePath(), 0666 ) ) ) trigger_error( "New::storeUploadedImage(): Couldn't set permissions on uploaded file.", E_USER_ERROR );
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
          trigger_error ( "New::storeUploadedImage(): Unhandled or unknown image type ($imageType)", E_USER_ERROR );
      }
 
      $this->update();
    }
  }
 
 
  /**
  * Deletes any images associated with the news
  */
 
  public function deleteImages() {
 
    // Delete all fullsize images for this news entry
    foreach (glob( NEW_IMAGE_PATH . "/" . IMG_TYPE_FULLSIZE . "/" . $this->newsID . ".*") as $filename) {
      if ( !unlink( $filename ) ) trigger_error( "New::deleteImages(): Couldn't delete image file.", E_USER_ERROR );
    }
 
    // Remove the image filename extension from the object
    $this->imageExtension_news = "";
  }
 
 
  /**
  * Returns the relative path to the new's full-size image
  *
  * @param string The type of image path to retrieve. Defaults to IMG_TYPE_FULLSIZE.
  * @return string|false The image's path, or false if an image hasn't been uploaded
  */
 
  public function getImagePath( $type=IMG_TYPE_FULLSIZE ) {
    return ( $this->newsID && $this->imageExtension_news ) ? ( NEW_IMAGE_PATH . "/$type/" . $this->newsID . $this->imageExtension_news ) : false;
  }
 
  

  /**
  * Returns a News object matching the given newsID
  *
  * @param int The newsID
  * @return New|false The news object, or false if the record was not found or there was a problem
  */

  public static function getById( $newsID ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT *, newsID AS newsID FROM news WHERE newsID = :newsID";
    $st = $conn->prepare( $sql );
    $st->bindValue( ":newsID", $newsID, PDO::PARAM_INT );
    $st->execute();
    $row = $st->fetch();
    $conn = null;
    if ( $row ) return new News( $row );
  }


  /**
  * Returns all (or a range of) News objects in the DB
  *
  * @param int Optional The number of rows to return (default=all)
  * @param string Optional column by which to order the articles (default="newsID DESC")
  * @return Array|false A two-element array : results => array, a list of News objects; totalRows => Total number of news
  */

public static function getList( $numRows=1000000, $order="newsID ASC" ) {

 $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

 //Your whitlelist of order bys.
 $order_whitelist = array("newsID ASC");

 // see if we have such a name, if it is not in the array then $order will be false.
        $order_check = array_search($order, $order_whitelist); 
    if ($order_check !== FALSE)
     {

     $sql = "SELECT SQL_CALC_FOUND_ROWS *, newsID AS newsID FROM news
        ORDER BY " . $order . " LIMIT :numRows";
     $st = $conn->prepare($sql);
     $st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
     $st->execute();
     $list = array();

     while ($row = $st->fetch())
         {
         $news = new News($row);
         $list[] = $news;
         }
     }

    // Now get the total number of articles that matched the criteria
    $sql = "SELECT FOUND_ROWS() AS totalRows";
    $totalRows = $conn->query( $sql )->fetch();
    $conn = null;
    return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
  }


  /**
  * Inserts the current News object into the database, and sets its ID property.
  */

  public function insert() {
	
	$this->newsID = null;
    // Does the News object already have an ID?
    if ( !is_null( $this->newsID ) ) trigger_error ( "News::insert(): Attempt to insert a News object that already has its ID property set (to $this->newsID).", E_USER_ERROR );

    // Insert the News
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "INSERT INTO news ( imageExtension_news, content, title ) VALUES ( :imageExtension_news, :content, :title )";
    $st = $conn->prepare ( $sql );
	$st->bindValue( ":imageExtension_news", $this->imageExtension_news, PDO::PARAM_STR );
	$st->bindValue( ":content", $this->content, PDO::PARAM_STR );
    $st->bindValue( ":title", $this->title, PDO::PARAM_STR );
    $st->execute();
    $this->newsID = $conn->lastInsertId();
    $conn = null;
  }


  /**
  * Updates the current News object in the database.
  */

  public function update() {

    // Does the News object have an ID?
    if ( is_null( $this->newsID ) ) trigger_error ( "News::update(): Attempt to update an Article object that does not have its ID property set.", E_USER_ERROR );
   
    // Update the News
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "UPDATE news SET imageExtension_news=:imageExtension_news, content=:content, title=:title WHERE newsID = :newsID";
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":imageExtension_news", $this->imageExtension_news, PDO::PARAM_STR );
	$st->bindValue( ":content", $this->content, PDO::PARAM_STR );
    $st->bindValue( ":title", $this->title, PDO::PARAM_STR );
    $st->bindValue( ":newsID", $this->newsID, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }


  /**
  * Deletes the current News object from the database.
  */

  public function delete() {

    // Does the News object have an ID?
    if ( is_null( $this->newsID ) ) trigger_error ( "News::delete(): Attempt to delete an Article object that does not have its ID property set.", E_USER_ERROR );

    // Delete the News
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $st = $conn->prepare ( "DELETE FROM news WHERE newsID = :newsID LIMIT 1" );
    $st->bindValue( ":newsID", $this->newsID, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }

}

?>
