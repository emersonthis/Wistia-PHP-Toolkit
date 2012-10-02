<?php
/**
* Wistia PHP Class Library - API Class
*
* @author Thorne N. Melcher <tmelcher@portdusk.com>
* @copyright Copyright 2012, Thorne N. Melcher
* @license LGPL v3 (see LICENSE.txt)
*
* Class to represent medias hosted on Wistia. Medias cannot be created using the API and must be made through WistiaProject's getUploaderCode() function, 
* which allows you to embed an uploader for that project (and all medias "belong" to a project).
*/
class WistiaMedia {
	protected $id;
	protected $name;
	protected $duration;
	protected $embedCode = "";
	protected $type;
	protected $created;
	protected $updated;
	
	protected $api; //WistiaAPI object

	/**
	* Constructor function. Optional second parameter lets you pre-populate the object with information.
	*/
	public function __construct($api, $obj=null) {
		$this->api = $api;
	
		if($obj!=null) {
			foreach($obj as $key => $value) {
				if(property_exists("WistiaMedia", $key)) {
					$this->$key = $value;
				}
			}
		}
	}
	
	public function getCreated() {
		return $this->created;
	}
	
	/**
	* Returns the duration of the media (in seconds).
	*/
	public function getDuration() {
		return $this->duration;
	}
	
	/**
	* Gets the code to embed the media on a page.
	*/
	public function getEmbedCode() {
		// WistiaMedia objects loaded secondarily through loading a project won't have all data.
		if($this->id != "" && $this->embedCode == "") {
			$curl = curl_init('https://api.wistia.com/v1/medias/'.$this->id.'.json');
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);                         
			curl_setopt($curl, CURLOPT_USERPWD, 'api:' . $this->api->getKey());
			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);                    
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);                          
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			$response = json_decode(curl_exec($curl));
			
			foreach($obj as $key => $value) {
				if(property_exists("WistiaMedia", $key)) {
					$this->$key = $value;
				}
			}
		}
		
		return $this->embedCode;
	}
	
	/**
	 * Gets the media's ID.
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Gets the media's name (default: filename at upload).
	 */
	public function getName() {
		return $this->name;	
	}
	
	/**
	 * Gets the media's type ("Video", "Image", "Audio", "Swf", "MicrosoftOfficeDocument", "PdfDocument", or "UnknownType").
	 */
	public function getType() {
		return $this->type;
	}
	
	public function getUpdated() {
		return $this->updated;	
	}
}