<?php

require 'autoload.php';

use App\User;
echo "<pre>";
/* id-i 2 olan useri cekmesi ucun query */
$user = User::get( 2 );

var_dump( $user->name ); // netice: Tahir or null


/* emaili alikamal@gmail.com ve pass-i (shifre) 12345 olan user */
$user = User::where( 'email', '=', 'alikamal@gmail.com' )->where( 'pass', '=', '12345' )->fetch();

var_dump( $user ); // eger varsa obyekt olaraq qaytaracaq sutunu yoxdursa, null


/* id-i 1-den boyuk olan butun userleri ceksin ve foreachle adlarini cap etsin */
$users = User::where( 'id', '>', 1 )->fetchAll();

foreach ( $users as $user )
{
    echo $user->name;
}


?>