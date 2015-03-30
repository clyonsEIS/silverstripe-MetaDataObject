<?php

class MetaDataObject extends DataExtension {

	private static $db = array(
		'MetaTitle' => 'Varchar(255)',
		'OGTitle' => 'Varchar(255)',
		'MetaDescription' => 'Text',
		'OGDescription' => 'Text',
	);

	private static $has_one = array(
		'OGImage' => 'Image'
	);

	public function updateCMSFields(FieldList $fields)
	{
		$fields->removeByName(array(
			'MetaTitle',
			'OGTitle',
			'MetaDescription',
			'OGDescription',
			'OGImage'
		));

		$fields->addFieldsToTab('Root.Meta', array(
				LiteralField::create('Message',
					'<div class="message warning">Fallback data may be provided for each of the fields below if left blank.</div>'
				),
				TextField::create('MetaTitle')
					->setTitle('Meta Title'),
				TextField::create('OGTitle')
					->setTitle('OG Title'),
				TextAreaField::create('MetaDescription')
					->setTitle('Meta Description'),
				TextAreaField::create('OGDescription')
					->setTitle('OG Description'),
				UploadField::create('OGImage')
					->setTitle('OG Image')
					->setFolderName('Meta')
			)
		);
	}

	public function DataObjectMeta()
	{
		$textTypes = array(
			'MetaTitle',
			'OGTitle',
			'MetaDescription',
			'OGDescription'
		);

		$meta = array();
		foreach($textTypes as $textType) {
			$getter = "getDefault" . $textType;
			$meta[$textType] = trim($this->owner->$textType) ? $this->owner->$textType : $this->owner->$getter();
		}

		if($this->owner->OGImage() && $this->owner->OGImage()->ID > 0) {
			$meta['OGImage'] = $this->owner->OGImage();
		} else {
			$meta['OGImage'] = $this->owner->getDefaultOGImage();
		}
		return $meta;
	}

	//Empty getter methods so these can be declared (or not) at will, rather than interface insistence
	public function getDefaultMetaTitle(){}
	public function getDefaultOGTitle(){}
	public function getDefaultMetaDescription(){}
	public function getDefaultOGDescription(){}
	public function getDefaultOGImage(){}

}
