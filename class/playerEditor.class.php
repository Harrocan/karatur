<?php
/**
*   Klasa sluzaca do edycji adnych gracza-celu ... na bazarach, w bankach itp.
*   (C) 2006-2007 Kara-Tur Team based on Vallheru Team
*
*   @name playerEditor.class.php
*   @author IvaN <ivan@o2.pl>
*   @version 0.1 alfa
*   @since 01.04.2007
*
*/

require_once( 'globalfunctions.php' );

class playerEditor {
  private $id;
  function __construct( $pid ) {
    $this->id = $pid;
  }
  
  function __get( $field ) {
    switch( $field ) {
      case 'gold' :
      case 'bank' :
      case 'mithril' :
      case 'copper' :
        return $this->GetResource( $field );
        break;
      default :
        trigger_error( "Pobranie nieprawidlowego pola : $field !", E_USER_ERROR );
        break;
    }
  }
  
  function __set( $field, $value ) {
    switch( $field ) {
      case 'gold' :
      case 'bank' :
      case 'mithril' :
      case 'copper' :
        $this->SetResource( $field, $value );
        break;
      default :
        trigger_error( "Ustawienie nieprawidlowego pola : $field !", E_USER_ERROR );
        break;
  }
  
  function GetResource( $field ) {
    $data = SqlExec( "SELECT $field FROM resources WHERE id={$this->id}" );
    return $data->fields[$field];
  }
  
  function SetResource( $res, $amount ) {
    SqlExec( "UPDATE resources SET `$res`='$amount' WHERE id={$this->id}" );
    PutSignal( $this->id, 'res' );
  }
}

?>