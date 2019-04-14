<?php
ini_set( "display_errors", true );
date_default_timezone_set( "America/Sao_Paulo" );  // http://www.php.net/manual/en/timezones.php
define( "DB_DSN", "mysql:host=localhost;dbname=tupbgo33_1087164" );
define( "DB_USERNAME", "tupbgo33_admin" );
define( "DB_PASSWORD", "paibenedito2017" );
define( "CLASS_PATH", "classes" );
define( "TEMPLATE_PATH", "templates" );
define( "HOMEPAGE_NUM_ARTICLES", 3 );
define( "ADMIN_USERNAME", "giramundo" );
define( "ADMIN_PASSWORD", "paibenedito2017" );
define( "ADMIN_USERNAME_2", "sergio" );
define( "ADMIN_PASSWORD_2", "paigiramundo" );
define( "ARTICLE_IMAGE_PATH", "images/articles" );
define( "NEW_IMAGE_PATH", "images/news" );
define( "IMG_TYPE_FULLSIZE", "fullsize" );
define( "IMG_TYPE_THUMB", "thumb" );
define( "JPEG_QUALITY", 100 );
require( CLASS_PATH . "/Article.php" );
require( CLASS_PATH . "/Course.php" );
require( CLASS_PATH . "/News.php" );
require( CLASS_PATH . "/Book.php" );

setlocale(LC_ALL, 'portuguese-brazilian', 'ptb');

function handleException( Throwable $t ) {
echo "Oops! Tivemos um problema. Tente Novamente mais tarde." . $t;
error_log( $t->getMessage() );
}

set_exception_handler( 'handleException' );
?>
