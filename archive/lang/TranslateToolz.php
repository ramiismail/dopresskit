<?php 
class TranslateToolz
{
	static protected $_translations;
	static protected $_translated;
	
	static protected $_language;
	static protected $_languages;
	
	public static function getLanguages()
	{
		if (!isset(self::$_languages))
		{
			$languages = array(
				'en' => 'English',
			);
			if ($handle = opendir('lang')) 
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
		}
		return self::$_languages;
	}

	public static function loadLanguage($language, $file)
	{
		self::$_language = $language;
		
		$languages = self::getLanguages();
		
		if (isset($languages[$language]) && file_exists('lang/'. $language .'-'. $languages[$language]. '.xml'))
		{
			$xml = simplexml_load_file('lang/'. $language .'-'. $languages[$language]. '.xml');
			
			self::$_translations = array();
			foreach ($xml as $set)
			{
				$attr = $set->attributes();
				if (!isset($attr['filename']) || $attr['filename'] == $file)
				{
					foreach ($set as $translation)
					{
						self::$_translations[(string)$attr['name']][(string)$translation->base] = $translation->local;
					}			
				}		
			}
		}
	}
	
	public static function translate($set, $text, $args = array(), $isHtml = false)
	{
		self::$_translated[] = $text;
		
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
		else if (self::$_language != 'en')
		{ 	
			$text = '<span style="color:red">' . $text .'</span>';
			$found = false;
		}
	
		if (count($args) > 0)
		{
			$text = vsprintf($text, $args);
		}
		
		if (!$isHtml && $found)
		{
			$text = htmlspecialchars($text);
		}
		
		if ($direction !== null)
			$text = '<span dir="'. $direction .'">'. $text .'</span>';
	
		return $text;
	}
	
	public static function makeBaseXml()
	{
		$xml = '';
		foreach (self::$_translated as $translate)
		{
			if (strpos($translate, '<') !== false)
				$translate = '<![CDATA['. $translate .']]>';
			else
				$translate = htmlspecialchars($translate);
			
			$xml .= '<translation>' ."\n";
			$xml .= '	<base>'. $translate .'</base>' ."\n";
			$xml .= '	<local>'. $translate .'</local>' ."\n";
			$xml .= '</translation>' ."\n";
		}
	
		return $xml;
	}
}

// Convenience functions

function tl($text)
{
	$args = func_get_args();
	$args = array_slice($args, 1);
	return TranslateToolz::translate('default', $text, $args, false);
}

function tlSet($set, $text)
{
	$args = func_get_args();
	$args = array_slice($args, 2);
	return TranslateToolz::translate($set, $text, $args, false);
}

function tlHtml($text)
{
	$args = func_get_args();
	$args = array_slice($args, 1);
	return TranslateToolz::translate('default', $text, $args, true); 
}
