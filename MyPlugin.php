<?php
/**
 * @package MyPlugin
 * @version 1.0.1
 */
/*
Plugin Name: MyPlugin
Plugin URI: http://wordpress.org/plugins/PluginPost/
Description: Cambia las palabras mal sonantes almacenadas en la base de datos
Author: Yo
Version: 1.0.1
*/


function crearBaseDatost(){
  


global $wpdb;

$charset_collate = $wpdb->get_charset_collate();

// le añado el prefijo a la tabla
$table_name = $wpdb->prefix . 'palabrosFeos';

// creamos la sentencia sql

$sql = "CREATE TABLE IF NOT EXISTS $table_name (
id integer(100)  NOT NULL AUTO_INCREMENT,
malsonante varchar(80),
correccion varchar(80),
PRIMARY KEY(id)
) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
}
add_action('init','crearBaseDatost');

    
  function modificacion($text) {
    
    global $wpdb;
    
    $table_name = $wpdb ->prefix . 'palabrosFeos';
    
    $malsonante = $wpdb->get_results("SELECT malsonante FROM $table_name", OBJECT);
    $correccion = $wpdb->get_results("SELECT correccion FROM $table_name", OBJECT);
    
    $buscar=array();
    $cambiar=array();
    
    for($i=0;$i<count($malsonante);$i++) {
        array_push($buscar,$malsonante[$i]->malsonante);
        array_push($cambiar,$correccion[$i]->correccion);
    };
    
return str_replace( $buscar, $cambiar, $text );

}

add_filter( 'the_content', 'modificacion' );


?>