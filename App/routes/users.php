<?php
ini_set ( 'display_errors' , 0 );

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

/**
 * Get list of users
 */
$app -> get ( '/api/users' , function ( Request $request , Response $response ) {
    $user_db = file_get_contents ( __DIR__ . '/../jsonDB/users.json' );
    return $response -> withJSON (
        json_decode ( $user_db , 1 ) ,
        200 ,
        JSON_UNESCAPED_UNICODE
    );
} );

/**
 * Get User By ID
 */
$app -> get ( '/api/users/{id}' , function ( Request $request , Response $response , array $args ) {
    $user_db = json_decode ( file_get_contents ( __DIR__ . '/../jsonDB/users.json' ) , 1 );
    if ( !empty( $user_db[ $args[ 'id' ] ] ) ) {
        return $response -> withJSON (
            $user_db[ $args[ 'id' ] ] ,
            200 ,
            JSON_UNESCAPED_UNICODE );
    } else {
        return "User с ID " . $args[ 'id' ] . " не найден!";
    }

} );

/**
 * Add new user
 */
$app -> post ( '/api/users/add' , function ( Request $request , Response $response ) {
    $user_db = json_decode ( file_get_contents ( __DIR__ . '/../jsonDB/users.json' ) , 1 );
    $name = $request -> getParam ( 'name' );

    if ( !empty( $user_db ) && !empty( $name ) ) {
        $last_id = intval ( end ( $user_db )[ 'id' ] );
        $id = $last_id + 1;
        $add_user = [
            'id' => $id ,
            'name' => $name ,
            'date_create' => date ( 'd-m-Y H:i:s' ) ,
            'date_modify' => date ( 'd-m-Y H:i:s' ) ,
        ];
        array_push ( $user_db , $add_user );
    } elseif ( empty( $user_db ) && !empty( $name ) ) {
        $id = 0;
        $add_user = [
            'id' => $id ,
            'name' => $name ,
            'date_create' => date ( 'd-m-Y H:i:s' ) ,
            'date_modify' => date ( 'd-m-Y H:i:s' ) ,
        ];
        $user_db = [ $add_user ];
    } else {
        return $response -> withJSON (
            "Неправильно введенные данные" ,
            404 ,
            JSON_UNESCAPED_UNICODE );
    }

    file_put_contents ( __DIR__ . '/../jsonDB/users.json' , json_encode ( $user_db ) );
    return $response -> withJSON (
        $add_user ,
        200 ,
        JSON_UNESCAPED_UNICODE );

} );

/**
 * Delete user
 */
$app -> delete ( '/api/users/delete/{id}' , function ( Request $request , Response $response , array $args ) {
    $user_db = json_decode ( file_get_contents ( __DIR__ . '/../jsonDB/users.json' ) , 1 );
    if ( !empty( $args[ 'id' ] ) && $user_db[ $args[ 'id' ] ] ) {
        unset( $user_db[ $args[ 'id' ] ] );
        file_put_contents ( __DIR__ . '/../jsonDB/users.json' , json_encode ( $user_db ) );
        return $response -> withJSON (
            "User with id " . $args[ 'id' ] . " deleted" ,
            200 ,
            JSON_UNESCAPED_UNICODE );
    } else {
        return $response -> withJSON (
            "User with id " . $args[ 'id' ] . " not found" ,
            404 ,
            JSON_UNESCAPED_UNICODE );
    }
} );

/**
 * Edit user
 */
$app -> put ( '/api/users/edit/{id}' , function ( Request $request , Response $response , array $args ) {
    $user_db = json_decode ( file_get_contents ( __DIR__ . '/../jsonDB/users.json' ) , 1 );
    $name = $request -> getParam ( 'name' );

    $user_db[ $args[ 'id' ] ][ 'name' ] = $name;
    $user_db[ $args[ 'id' ] ][ 'date_modify' ] = date ( 'd-m-Y H:i:s' );

    file_put_contents ( __DIR__ . '/../jsonDB/users.json' , json_encode ( $user_db ) );
    return $response -> withJSON (
        "User with id " . $args[ 'id' ] . " has changed" ,
        200 ,
        JSON_UNESCAPED_UNICODE );
} );








