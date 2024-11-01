<?php
/**
 * @package Wordpress SmileBox Widget
 * @author Igor Karpov <mail@noxls.net>
 * @link https://noxls.net
 *
 */


final class SmileBoxWidget_Commons {
	
	const FILENAME = 'nx-smile-box-widget.php';
	const TEXTDOMAIN = 'smile-box-widget';

	// These properties will be defined when performing setUpStaticProperties() method.
	static public $sPluginFilePath ='';	// must set a value as it will be cheched in setUpStaticProperties()
	static public $sPluginDirPath ='';
	static public $sPluginName ='';
	static public $sPluginURI ='';
	static public $sPluginDescription ='';
	static public $sPluginAuthor ='';
	static public $sPluginAuthorURI ='';
	static public $sPluginVersion ='';
	static public $sPluginTextDomain ='';
	static public $sPluginDomainPath ='';
	static public $sPluginNetwork ='';
	static public $sPluginSiteWide ='';
	static public $sPluginStoreURI ='';

	static function setUp( $sPluginFilePath=null ) {
		
		self::$sPluginFilePath = $sPluginFilePath ? $sPluginFilePath : dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . self::FILENAME;
		self::$sPluginDirPath = dirname( self::$sPluginFilePath );
		self::$sPluginURI = plugins_url( '', self::$sPluginFilePath );
		
		$arrPluginData = get_file_data( 
			self::$sPluginFilePath, 
			array(
				'sPluginName' => 'Plugin Name',
				'sPluginURI' => 'Plugin URI',
				'sPluginVersion' => 'Version',
				'sPluginDescription' => 'Description',
				'sPluginAuthor' => 'Author',
				'sPluginAuthorURI' => 'Author URI',
				'sPluginTextDomain' => 'Text Domain',
				'sPluginDomainPath' => 'Domain Path',
				'sPluginNetwork' => 'Network',
				'sPluginSiteWide' => 'Site Wide Only',	// Site Wide Only is deprecated in favor of Network.
				'sPluginStoreURI' => 'Store URI',
			),
			'plugin' 
		);
		
		foreach( $arrPluginData as $sKey => $sValue )
			if ( isset( self::${$sKey} ) )	// must be checked as get_file_data() returns a filtered result
				self::${$sKey} = $sValue;
	
	}	
	
	public static function getPluginURL( $sRelativePath='' ) {
		return plugins_url( $sRelativePath, self::$sPluginFilePath );
	}

	
}