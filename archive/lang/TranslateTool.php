<?php 
class TranslateTool
{
	static protected $_translations;
	
	static protected $_translated;
	static protected $_untranslated;
	
	static protected $_language;
	static protected $_defaultLanguage;
	static protected $_languages;
	
	public static function getLanguages()
	{
		if (!isset(self::$_languages))
		{
			$languages = array(
				'en' => 'English',
			);
			if ($handle = opendir(dirname(__FILE__))) 
			{
				while (false !== ($entry = readdir($handle))) 
				{
					if (substr($entry,-4) == ".xml" )
					{
						$info = explode('-', substr($entry,0, -4), 2);
						$languages[$info[0]] = $info[1];
					}
				}
			}
			
			self::$_languages = $languages;
			self::$_defaultLanguage = key($languages);
		}
		return self::$_languages;
	}

	public static function loadLanguage($language, $file)
	{
		$languages = self::getLanguages();

		if (!isset($languages[$language]))
			$language = self::$_defaultLanguage;
		
		self::$_language = $language;
				
		if (isset($languages[$language]) && file_exists(dirname(__FILE__) . '/'. $language .'-'. $languages[$language]. '.xml'))
		{
			$xml = simplexml_load_file(dirname(__FILE__) . '/'. $language .'-'. $languages[$language]. '.xml');
			
			self::$_translations = array();
			foreach ($xml as $set)
			{
				$setAttr = $set->attributes();
				$setName = isset($setAttr['name']) ? $setAttr['name'] : 'default';
				if (!isset($setAttr['filename']) || $setAttr['filename'] == $file)
				{
					foreach ($set as $translation)
					{
						self::$_translations[(string)$setName][(string)$translation->base] = $translation->local;
					}			
				}		
			}
		}
		
		return self::$_language;
	}
	
	public static function getDefaultLanguage()
	{
		self::getLanguages();
		return self::$_defaultLanguage;
	}
	
	public static function translate($set, $text, $args = array(), $isHtml = false)
	{
		$defaultText = $text;
			
		$found = true;
		$direction = null;
		if (isset(self::$_translations[$set][$text]))
		{
			if (isset(self::$_translations[$set][$text]->attributes()->direction))
				$direction = self::$_translations[$set][$text]->attributes()->direction;
			
			$text = self::$_translations[$set][$text];
		}
		else if (isset(self::$_translations['default'][$text]))
		{
			if (isset(self::$_translations['default'][$text]->attributes()->direction))
				$direction = self::$_translations['default'][$text]->attributes()->direction;
			
			$text = self::$_translations['default'][$text];
		}
		else 
		{
			self::$_untranslated[$defaultText] = $text;
			$found = false;
		}
		self::$_translated[$defaultText] = $text;
		
		if (count($args) > 0)
		{
			$text = vsprintf($text, $args);
		}
		
		if (!$isHtml)
		{
			$text = htmlspecialchars($text);
		}
		
		if (!$found && self::$_language != 'en')
			$text = '<span style="color:red">' . $text .'</span>';
		
		if ($direction !== null)
			$text = '<span dir="'. $direction .'">'. $text .'</span>';
	
		return $text;
	}
	
	public static function makeBaseXml($untranslated = true)
	{
		$translations = $untranslated ? self::$_untranslated : self::$_translated;
		
		$xml = '';
		foreach ($translations as $base => $local)
		{
			if (strpos($base, '<') !== false)
				$base = '<![CDATA['. $base .']]>';
			else
				$base = htmlspecialchars($base);
			
			if (strpos($local, '<') !== false)
				$base = '<![CDATA['. $local .']]>';
			else
				$base = htmlspecialchars($local);
			
			$xml .= '		<translation>' ."\n";
			$xml .= '			<base>'. $base .'</base>' ."\n";
			$xml .= '			<local>'. $local .'</local>' ."\n";
			$xml .= '		</translation>' ."\n";
		}
	
		return $xml;
	}
}

// Convenience functions

function tl($text)
{
	$args = func_get_args();
	$args = array_slice($args, 1);
	return TranslateTool::translate('default', $text, $args, false);
}

function tlSet($set, $text)
{
	$args = func_get_args();
	$args = array_slice($args, 2);
	return TranslateTool::translate($set, $text, $args, false);
}

function tlHtml($text)
{
	$args = func_get_args();
	$args = array_slice($args, 1);
	return TranslateTool::translate('default', $text, $args, true); 
}
