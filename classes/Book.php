<?php

/**
 * Class to handle books
 */

class Book
{
  // Properties

  /**
  * @var int The book ID from the database
  */
  public $bookID = null;
  
  /**
  * @var string Full title of the book
  */
  public $bookTitle = null;

  /**
  * @var string Name of the books medium
  */
  public $bookMedium = null;

  /**
  * @var string Name of the books spiritual author (if applicable)
  */
  public $bookAuthor = null;
  
    /**
  * @var string The ISBN number of the book
  */
  public $ISBN = null;
  
     /**
  * @var string The link to buy the book online
  */
  public $bookLink = null;


  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */

  public function __construct( $data=array() ) {
    if ( isset( $data['bookID'] ) ) $this->bookID = (int) $data['bookID'];
    if ( isset( $data['bookTitle'] ) ) $this->bookTitle = $data['bookTitle'];
    if ( isset( $data['bookMedium'] ) ) $this->bookMedium = $data['bookMedium'];
	if ( isset( $data['bookAuthor'] ) ) $this->bookAuthor = $data['bookAuthor'];
	if ( isset( $data['ISBN'] ) ) $this->ISBN = $data['ISBN'];
	if ( isset( $data['bookLink'] ) ) $this->bookLink = $data['bookLink'];
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
  * Returns a Book object matching the given book ID
  *
  * @param int The book ID
  * @return Book|false The book object, or false if the record was not found or there was a problem
  */

  public static function getById( $bookID ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT *, bookID AS bookID FROM books WHERE bookID = :bookID";
    $st = $conn->prepare( $sql );
    $st->bindValue( ":bookID", $bookID, PDO::PARAM_INT );
    $st->execute();
    $row = $st->fetch();
    $conn = null;
    if ( $row ) return new Book( $row );
  }


  /**
  * Returns all (or a range of) Book objects in the DB
  *
  * @param int Optional The number of rows to return (default=all)
  * @param string Optional column by which to order the books (default="bookID DESC")
  * @return Array|false A two-element array : results => array, a list of Book objects; totalRows => Total number of articles
  */

public static function getList( $numRows=1000000, $order="bookID DESC" ) {

 $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

 //Your whitlelist of order bys.
 $order_whitelist = array("bookID DESC");

 // see if we have such a name, if it is not in the array then $order will be false.
        $order_check = array_search($order, $order_whitelist); 
    if ($order_check !== FALSE)
     {

     $sql = "SELECT SQL_CALC_FOUND_ROWS *, bookID AS bookID FROM books
        ORDER BY " . $order . " LIMIT :numRows";
     $st = $conn->prepare($sql);
     $st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
     $st->execute();
     $list = array();

     while ($row = $st->fetch())
         {
         $book = new Book($row);
         $list[] = $book;
         }
     }

    // Now get the total number of books that matched the criteria
    $sql = "SELECT FOUND_ROWS() AS totalRows";
    $totalRows = $conn->query( $sql )->fetch();
    $conn = null;
    return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
  }


  /**
  * Inserts the current Book object into the database, and sets its ID property.
  */

  public function insert() {

	$this->bookID = null;
    // Does the Book object already have an ID?
    if ( !is_null( $this->bookID ) ) trigger_error ( "Book::insert(): Attempt to insert a Book object that already has its ID property set (to $this->bookID).", E_USER_ERROR );

    // Insert the Book
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "INSERT INTO books ( bookTitle, bookMedium, bookAuthor, ISBN, bookLink ) VALUES ( :bookTitle, :bookMedium, :bookAuthor, :ISBN, :bookLink )";
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":bookTitle", $this->bookTitle, PDO::PARAM_STR );
    $st->bindValue( ":bookMedium", $this->bookMedium, PDO::PARAM_STR );
    $st->bindValue( ":bookAuthor", $this->bookAuthor, PDO::PARAM_STR );
	$st->bindValue( ":ISBN", $this->ISBN, PDO::PARAM_STR );
	$st->bindValue( ":bookLink", $this->bookLink, PDO::PARAM_STR );
    $st->execute();
    $this->bookID = $conn->lastInsertId();
    $conn = null;
  }


  /**
  * Updates the current Book object in the database.
  */

  public function update() {

    // Does the Book object have an ID?
    if ( is_null( $this->bookID ) ) trigger_error ( "Book::update(): Attempt to update a Book object that does not have its ID property set.", E_USER_ERROR );
   
    // Update the Book
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "UPDATE books SET bookTitle=:bookTitle, bookMedium=:bookMedium, bookAuthor=:bookAuthor, ISBN=:ISBN, bookLink=:bookLink WHERE bookID = :bookID";
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":bookTitle", $this->bookTitle, PDO::PARAM_STR );
    $st->bindValue( ":bookMedium", $this->bookMedium, PDO::PARAM_STR );
    $st->bindValue( ":bookAuthor", $this->bookAuthor, PDO::PARAM_STR );
	$st->bindValue( ":ISBN", $this->ISBN, PDO::PARAM_STR );
	$st->bindValue( ":bookLink", $this->bookLink, PDO::PARAM_STR );
    $st->bindValue( ":bookID", $this->bookID, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }


  /**
  * Deletes the current Book object from the database.
  */

  public function delete() {

    // Does the Book object have an ID?
    if ( is_null( $this->bookID ) ) trigger_error ( "Book::delete(): Attempt to delete a Book object that does not have its ID property set.", E_USER_ERROR );

    // Delete the Book
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $st = $conn->prepare ( "DELETE FROM books WHERE bookID = :bookID LIMIT 1" );
    $st->bindValue( ":bookID", $this->bookID, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }

}

?>
