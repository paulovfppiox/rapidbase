<?php
require_once 'cors.php';
require_once __DIR__ . '/vendor/autoload.php';
use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Response;

/************* I- INSERT **************/
 function InsertExample()              {
    $input = '{ "id": "1", "title": "Lord", "book_id": "1", "published_date": "2024-01-01" }';
    $data_array = json_decode($input, true);
    print_r( $data_array );

    $author = new Book;
    $resp = $author->insert( $data_array );
    print_r( $resp );
}
// InsertExample();

/************* II- UPDATE **************/
function UpdateExample()                {
    $input = '{ "id": "1", "title": "Lord of Rings II", "book_id": "1", "published_date": "2023-01-01" }';
    $data_array = json_decode($input, true);

    $author = new Book;
    $resp = $author->update( $data_array );
    print_r( $resp );
}
// UpdateExample();

/************* III- DELETE **************/
function DeleteExample()    {
    $input = '{ "id": "1" }';
    $data_array = json_decode($input, true);

    $author = new Book;
    $resp = $author->delete( $data_array );
    print_r( $resp );
}

/**************** IV- GET **************/
function GetExample()    {
    $author = new Book;
    $resp = $author->getBookById( 1 );
    echo "<br><br>---- Get Example Data ----<br>";
    print_r( $resp );
}
DeleteExample();
InsertExample();
UpdateExample();
GetExample();
?>