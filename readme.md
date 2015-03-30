# silverstripe-MetaDataObject

##Requirements
* Silverstripe 3.1+

##Installation
* Install to silverstripe root
* `dev/build`

##Usage
Apply the extension to your custom DataObject class.
```yml
CustomDataObject:
  extensions:
    - 'MetaDataObject'
```

Optional - provide fallback methods for each of the available meta properties.  
```php
	public function getDefaultMetaTitle()
	{
		return ...;
	}
	public function getDefaultMetaDescription()
	{
		return ...;
	}
	public function getDefaultOGDescription()
	{
		return ...;
	}
	public function getDefaultOGImage()
	{
		return ...;
	}
```

In your controller action, retrieve the meta data by calling DataObjectMeta on the item, i.e.
```php
	public function view() {
		$item = $this->getItem();
        ...
		$meta = $item->DataObjectMeta();
		return array_merge(
			$meta,
			array(
               'OtherData' => $OtherData
			)
		);
	}
```

Your template should be set up to display the fields individually, rather than the SS/Simple merged MetaTags. i.e.
```xhml
    <title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> - $SiteConfig.Title</title>
    <meta name="description" content="$MetaDescription.ATT" />
    <meta property="og:site_name" content="$SiteConfig.Title.ATT" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="$Title.ATT" />
    <meta property="og:description" content="$OGDescription.ATT" />
    <meta property="og:url" content="$AbsoluteLink.ATT" />
	<% if $OGImage %>
        <meta property="og:image" content="<% with $OGImage.SetSize(500,500) %>$AbsoluteURL.ATT<% end_with %>" />
	<% end_if %>
```


##About
The goal of this module is to be extremely light weight and flexible for use in a variety of controller routing situations.  Controller action integration is intentionally not included.
For a more fully-featured module to handle viewing DataObjects as pages, see https://github.com/arambalakjian/DataObject-as-Page 

##Contributing
Pull requests & issues are welcome to make this module more flexible & powerful. 