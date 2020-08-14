<?php 
namespace App\Helper;
/**
 * 
 */
class Common
{

	public function getFiles($directory)
    {
    	$rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory));
		$files = array(); 
		foreach ($rii as $file) {
		if ($file->isDir()){ 
		    continue;
		}
		$files[] = $file; 
		}
		return $files;
    }
	
	public function slugify($text)
	{
		$text = preg_replace('~[^\pL\d]+~u', '-', $text);
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		$text = preg_replace('~[^-\w]+~', '', $text);
		$text = trim($text, '-');
		$text = preg_replace('~-+~', '-', $text);
		$text = strtolower($text);
		if (empty($text)) {
		return 'n-a';
		}
		return $text;
	}

	public function unSlugify($text)
	{
		$text = preg_replace('~[^\pL\d]+~u', ' ', $text);
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		$text = preg_replace('~[^-\w]+~', ' ', $text);
		$text = trim($text, ' ');
		$text = preg_replace('~-+~', ' ', $text);
		$text = strtolower($text);
		if (empty($text)) {
		return 'n-a';
		}

		$text = explode(" ", $text);
		$text = array_map("ucfirst", $text);
		$text = implode(" ", $text);
		return $text;
	}
}
?>