<?php
/**
 * @package Wordpress SmileBox Widget
 * @author Igor Karpov <mail@noxls.net>
 * @link https://noxls.net
 *
 */
class SmileBoxWidget_Admin {
	
	function __construct( $sFilePath ) {
		
		$this->sFilePath = $sFilePath;
		add_filter( 'plugin_row_meta', array( $this, 'replyToaddLinksInPluginListingTable' ), 10, 2 );
		
	}
	
	public function replyToaddLinksInPluginListingTable( $arrLinks, $sFilePath ) {
		
		if ( $sFilePath != plugin_basename( $this->sFilePath ) ) return $arrLinks;
		
		// add links to the $arrLinks array.
		$arrLinks[] = '<a href="https://noxls.net/contacts?codecanyon_smile_box">' . __( 'Order custom plugin', 'smile-box-widget' ) . '</a>';
		return $arrLinks;
		
	} 
	
}