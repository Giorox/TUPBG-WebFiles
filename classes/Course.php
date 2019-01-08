<?php

/**
 * Class to handle courses
 */

class Course
{
  // Properties

  /**
  * @var int The course ID from the database
  */
  public $courseID = null;
  
  /**
  * @var string The course name
  */
  public $courseName = null;
  
  /**
  * @var string The course instructor's name
  */
  public $courseInstructor = null;

  /**
  * @var int When the course is set to start
  */
  public $courseStartDate = null;

  /**
  * @var int When the course is set to end
  */
  public $courseEndDate = null;

  /**
  * @var string Short description of the course
  */
  public $courseDescription = null;
 
 /**
  * @var string Price value
  */
  public $coursePrice = null;
  
  /**
  * @var int Course status
  */
  public $courseStatus = null;

  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */

  public function __construct( $data=array() ) {
    if ( isset( $data['courseID'] ) ) $this->courseID = (int) $data['courseID'];
	if ( isset( $data['courseName'] ) ) $this->courseName = $data['courseName'];
	if ( isset( $data['courseInstructor'] ) ) $this->courseInstructor = $data['courseInstructor'];
    if ( isset( $data['courseStartDate'] ) ) $this->courseStartDate = (int) $data['courseStartDate'];
	if ( isset( $data['courseEndDate'] ) ) $this->courseEndDate = (int) $data['courseEndDate'];
    if ( isset( $data['courseDescription'] ) ) $this->courseDescription = $data['courseDescription'];
    if ( isset( $data['coursePrice'] ) ) $this->coursePrice = $data['coursePrice'];
	if ( isset( $data['courseStatus'] ) ) $this->courseStatus = (int)preg_replace ( "/[^0-9]/", "", $data['courseStatus']);
  }


  /**
  * Sets the object's properties using the edit form post values in the supplied array
  *
  * @param assoc The form post values
  */

  public function storeFormValues ( $params ) {

    // Store all the parameters
    $this->__construct( $params );

    // Parse and store the course start date
    if ( isset($params['courseStartDate']) ) {
      $courseStartDate = explode ( '-', $params['courseStartDate'] );

      if ( count($courseStartDate) == 3 ) {
        list ( $y, $m, $d ) = $courseStartDate;
        $this->courseStartDate = mktime ( 0, 0, 0, $m, $d, $y );
      }
    }
	
	// Parse and store the course end date
    if ( isset($params['courseEndDate']) ) {
      $courseEndDate = explode ( '-', $params['courseEndDate'] );

      if ( count($courseEndDate) == 3 ) {
        list ( $y, $m, $d ) = $courseEndDate;
        $this->courseEndDate = mktime ( 0, 0, 0, $m, $d, $y );
      }
    }
  }
 
  /**
  * Returns an Course object matching the given course ID
  *
  * @param int The course ID
  * @return Course|false The course object, or false if the record was not found or there was a problem
  */

  public static function getById( $courseID ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT *, UNIX_TIMESTAMP(courseStartDate) AS courseStartDate FROM courses WHERE courseID = :courseID";
    $st = $conn->prepare( $sql );
    $st->bindValue( ":courseID", $courseID, PDO::PARAM_INT );
    $st->execute();
    $row = $st->fetch();
    $conn = null;
    if ( $row ) return new Course( $row );
  }


  /**
  * Returns all (or a range of) Course objects in the DB
  *
  * @param int Optional The number of rows to return (default=all)
  * @param string Optional column by which to order the courses (default="courseStartDate DESC")
  * @return Array|false A two-element array : results => array, a list of Course objects; totalRows => Total number of courses
  */

public static function getList( $numRows=1000000, $order="courseStartDate DESC" ) {

 $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

 //Your whitlelist of order bys.
 $order_whitelist = array("courseStartDate DESC");

 // see if we have such a name, if it is not in the array then $order will be false.
        $order_check = array_search($order, $order_whitelist); 
    if ($order_check !== FALSE)
     {

     $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(courseStartDate) AS courseStartDate FROM courses
        ORDER BY " . $order . " LIMIT :numRows";
     $st = $conn->prepare($sql);
     $st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
     $st->execute();
     $list = array();

     while ($row = $st->fetch())
         {
         $course = new Course($row);
         $list[] = $course;
         }
     }

    // Now get the total number of articles that matched the criteria
    $sql = "SELECT FOUND_ROWS() AS totalRows";
    $totalRows = $conn->query( $sql )->fetch();
    $conn = null;
    return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
  }


  /**
  * Inserts the current Course object into the database, and sets its ID property.
  */

  public function insert() {
	  
	$this->courseID = null;
    // Does the Course object already have an ID?
    if ( !is_null( $this->courseID ) ) trigger_error ( "Course::insert(): Attempt to insert a Course object that already has its ID property set (to $this->courseID).", E_USER_ERROR );

    // Insert the Course
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "INSERT INTO courses ( courseName, courseInstructor, courseStartDate, courseEndDate, courseDescription, coursePrice, courseStatus ) VALUES ( :courseName, :courseInstructor, FROM_UNIXTIME(:courseStartDate), FROM_UNIXTIME(:courseEndDate), :courseDescription, :coursePrice, :courseStatus )";
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":courseName", $this->courseName, PDO::PARAM_STR );
    $st->bindValue( ":courseInstructor", $this->courseInstructor, PDO::PARAM_STR );
    $st->bindValue( ":courseStartDate", $this->courseStartDate, PDO::PARAM_INT );
    $st->bindValue( ":courseEndDate", $this->courseEndDate, PDO::PARAM_INT );
	$st->bindValue( ":courseDescription", $this->courseDescription, PDO::PARAM_STR );
	$st->bindValue( ":coursePrice", $this->coursePrice, PDO::PARAM_STR );
	$st->bindValue( ":courseStatus", $this->courseStatus, PDO::PARAM_INT );
    $st->execute();
    $this->courseID = $conn->lastInsertId();
    $conn = null;
  }


  /**
  * Updates the current Course object in the database.
  */

  public function update() {

    // Does the Course object have an ID?
    if ( is_null( $this->courseID ) ) trigger_error ( "Course::update(): Attempt to update an Course object that does not have its ID property set.", E_USER_ERROR );
   
    // Update the Course
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "UPDATE courses SET courseName=:courseName, courseInstructor=:courseInstructor, courseStartDate=FROM_UNIXTIME(:courseStartDate), courseEndDate=FROM_UNIXTIME(:courseEndDate), courseDescription=:courseDescription, coursePrice=:coursePrice, courseStatus=:courseStatus WHERE courseID = :courseID";
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":courseName", $this->courseName, PDO::PARAM_STR );
    $st->bindValue( ":courseInstructor", $this->courseInstructor, PDO::PARAM_STR );
    $st->bindValue( ":courseStartDate", $this->courseStartDate, PDO::PARAM_INT );
    $st->bindValue( ":courseEndDate", $this->courseEndDate, PDO::PARAM_INT );
	$st->bindValue( ":courseDescription", $this->courseDescription, PDO::PARAM_STR );
	$st->bindValue( ":coursePrice", $this->coursePrice, PDO::PARAM_STR );
	$st->bindValue( ":courseStatus", $this->courseStatus, PDO::PARAM_INT );
    $st->bindValue( ":courseID", $this->courseID, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }


  /**
  * Deletes the current Course object from the database.
  */

  public function delete() {

    // Does the Course object have an ID?
    if ( is_null( $this->courseID ) ) trigger_error ( "Course::delete(): Attempt to delete an Course object that does not have its ID property set.", E_USER_ERROR );

    // Delete the Course
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $st = $conn->prepare ( "DELETE FROM courses WHERE courseID = :courseID LIMIT 1" );
    $st->bindValue( ":courseID", $this->courseID, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }

}

?>
