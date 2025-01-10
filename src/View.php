<?php

declare( strict_types = 1 );

namespace App;

class View
 {
    public function redner( string $page, array $params = [] ):void {
        $params = $this->escape( $params );
        include_once( 'templates/layout.php' );
    }

    private function escape( array $params ) : array {

        foreach ( $params as $key => $param ) {
            switch( true ) {
                case is_array( $param ) :
                $params[ $key ] = $this->escape( $param );
                break;
                case $param :
                $params[ $key ] = htmlentities( strval( $param ) );
                break;
                default:
                $params[ $key ] = $param;
                break;
            }
        }
        return $params;
    }
}
