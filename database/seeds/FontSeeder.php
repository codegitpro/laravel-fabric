<?php

use Illuminate\Database\Seeder;
use App\Model\Font;
use App\Helper\Common;

class FontSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $directory = public_path('backend\Fonts');
    	$files = (new Common())->getFiles($directory);
    	$this->insertFontsInDb($files, $directory);
    }

    public function insertFontsInDb($files, $directory)
    {
    	foreach ($files as $file) {
    		$path = $file->getPath();
    		$fileName = $file->getFileName();

    		$data['name'] = (new Common())->unSlugify(str_replace(".ttf", "", $file->getFileName()));
    		$data['slug'] = (new Common())->slugify($data['name']);
    		$data['path'] = 'backend\Fonts\\' . trim(str_replace($directory, "", $path) . "\\$fileName", '\\');
    		$data['edited_name'] = $data['name'];
    		$data['active'] = 1;
    		$fontObj = (new Font())->firstOrCreate($data);
    	}
    }
}
