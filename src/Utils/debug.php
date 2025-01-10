<?php

declare( strict_types = 1 );

error_reporting(E_ALL);
ini_set('display_errors','1');

function dump( $data ) : void {
  echo '<div 
    style="
      display:inline-block;
      padding:10px;
      background: lightgray;
      border: 1px solid gray;
      margin: 25px;
    "
  >
  <pre>';
  print_r($data);
  echo '</pre>
  </div>
  </br>'; 
}
