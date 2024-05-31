<?php
require_once 'cors.php';

/*******************************************************
 *               VALID INPUT JSON
 * {
"data":
{
	"entity":"author",
	"operation":"insert",
	"object":{
		"attributes":"values"
	}
  }
} * 
******************************************************/

require_once __DIR__ . '/vendor/autoload.php';
use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Response;
use App\Entity\ConfigurationAPI;

$current_time = microtime(true); // Get the current time with milliseconds
$SERVER_FORMATTED_TIME = date('H:i:s.') . sprintf("%03d", ($current_time - floor($current_time)) * 1000); // Format the time with milliseconds

/********************************************************************************************************************************************

      JSON -> {   "dados":{"entidade":"operacaoDetalhada","operacao":"consultar","objeto":{"data":"2023-04-25"} } }

********************************************************************************************************************************************/
function generateLog( $data )
{
      // Get the current month
      $currentMonth = date('Y-m');

      // Create the log file name
      $logFileName = 'log-' . $currentMonth . '.txt';
      $message = $data;
	
      $file = fopen($logFileName, 'a'); // MODO DE APPEND

      if ($file) {
          fwrite($file, $message . PHP_EOL);
          fclose($file);
      } 
}
echo "method? . " . $_SERVER[ 'REQUEST_METHOD' ];

if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' )
{
     // if ( ConfigurationAPI::$EXECUTION_MODE == 'DEBUG')
     // print_r( file_get_contents('php://input') );
     $jsonStrIn = file_get_contents( 'php://input' );
     $data = json_decode( $jsonStrIn, true );
     $logIn = "[ " . $SERVER_FORMATTED_TIME . " ] IN >> " . $jsonStrIn;
     generateLog( $logIn );

     echo $logIn ;

     if ( ( $data === null ) && ( json_last_error() !== JSON_ERROR_NONE ) )     {
          echo "Invalid JSON error: " . json_last_error_msg();
          exit;
     }
     $entityObj = null;
     $response  = null;

     $DATA_ENTITY = $data['data']['entity'];
     if ( isset( $data['data']['object'] ) )
          $DATA_OBJECT = $data['data']['object'];

     $DATA_OPERATION = $data['data']['operation'];

     switch ( $DATA_ENTITY )
     {
       case 'author' :
             $entityObj = new Author;
             break;

       case 'book' :
             $entityObj = new Book;
             break; 
     }

    switch ( $DATA_OPERATION )
    {
        case 'insert':
              print_r( $data['data']['object'] );
              echo 'Cadastra response ------- <br>';
              $response = $entityObj->insert( $DATA_OBJECT );
		 break;

        case 'update':
              $response = $entityObj->atualiza( $DATA_OBJECT );
              break; 

        case 'consultar':
              $response = $entityObj->select( $data['data']['object'] );
              break; 
    } 
     

    echo 'Entity?' . $DATA_ENTITY;
    echo "<br>Response é objeto? " . is_object( $response );
    echo "KKKKKKKKKKK >>>>" . $response;
 
    $json = stripslashes( json_encode( $response ) );
    echo $json;
    generateLog( "[ " . $SERVER_FORMATTED_TIME . " ] OUT << " . $json );
 }

 

?>
