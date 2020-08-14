<?php

namespace App\Http\Controllers\Frontend\CustomizeTemplate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Model\Template;
use App\Model\Font;
use App\Model\Mapping;
use App\Model\Logo;
use App\Model\ReadyToPrint;
use TCPDF;
use TCPDF_FONTS;

class CustomizeTemplateController extends Controller
{
	public function index($shopId, $templateId, $orderId)
	{
		if(!$this->exists($shopId, $templateId, $orderId)){
			abort(404);
		}

		$fonts = (new Font())->get();
		$mappings = (new Mapping())->get();
		$logo = (new Logo())->where('brand_slug', $shopId)->get()[0];
		$template = (new Template())->where('template_custom_id', $templateId)->get()[0];    	
		$mappingsIdMap = [];
		$fontSlugPathMap = [];
        
        $productBackgroundUrl = '';
		$mapingBackgroundInfo = [];
		foreach ($mappings as $key => $mapping) {
			$mappingsIdMap[$mapping->id] = $mapping;
    
			if($template->mapping_id == $mapping->id){
    			$productBackgroundUrl = url($mapping->product_background);
                $productBackgroundUrl = str_replace('\\', '/', $productBackgroundUrl);
    			$mapingBackgroundInfo = [
    				'width' => $mapping->product_background_width,
    				'height' => $mapping->product_background_height
    			]; 
			}
		}

		foreach ($fonts as $key => $font) {
			$fontSlugPathMap[$font->slug] = str_replace("\\", "/", $font->path);
		}
		
		$data = [
			'mappings' =>  $mappings,
			'template' =>  $template,
			'logo' => $logo,
			'fonts' => $fonts,
			'mappingsIdMap' => $mappingsIdMap,
			'fontSlugPathMap' => json_encode($fontSlugPathMap, JSON_UNESCAPED_UNICODE ),
			'mapingBackgroundInfo' => $mapingBackgroundInfo,
			'productBackgroundUrl' => $productBackgroundUrl
		];
		return view('frontend.customize_template.index', $data);
	}

	public function exists($shopId, $templateId, $orderId)
	{
		$idsExist = true;
		$logo = (new Logo())->where('brand_slug', $shopId)->get();
		$idsExist = ($idsExist) && (!$logo->isEmpty());

		$template = (new Template())->where('template_custom_id', $templateId)->get();
		$idsExist = ($idsExist) && (!$template->isEmpty());

		if(intval($orderId) != $orderId)
			$idsExist = false;

		return $idsExist;
	}

	public function uploadPhoto(Request $request)
	{
		$file = $request->file('file');
    	$name = time(). '_'. $file->getClientOriginalName(); //the logo image is being stired in the storage/logos
        $content = file_get_contents($file->getRealPath());
        $path = storage_path("app\public\uploadedPhotoes\\$name");
        $path = str_replace("\\", '/', $path);
        $this->saveFile($content, $path);
        $uploadedPathUrl = url("public/storage/uploadedPhotoes/$name");
        return ['uploadedPhoto' => $uploadedPathUrl];
	}

	public function create(StoreLogo $request)
    {
    	$file = $request->file('logo_file');
    	$data = $request->input();
    	unset($data['_token']);
        $data['brand_slug'] = (new Common())->slugify($data['brand_name']);
        $path = storage_path("app\public\\" . $data['brand_logo']);
        $logoObj = (new Logo());
        if($this->saveFile($content, $path))
            $logoObj->firstOrCreate($data);
        else{
            $request->session()->flash('error', 'Logo file already exists. Please delete it before uploading again.'); 
            return ['message' => 'Logo file already exists. Please delete it before uploading again.', 'status' => 'success', 'data' => ['logo' => $logoObj->toArray()]];
        }

        $request->session()->flash('success', 'Logo saved successfully'); 
        return ['message' => 'Logo saved sccessfully', 'status' => 'success', 'data' => ['logo' => $logoObj->toArray()]];
    }

    public function saveFile($content, $destinationPath)
    {
        if(file_exists($destinationPath)){
            return false;
        }
    	return file_put_contents($destinationPath, $content);
    }

    public function saveOrder(Request $request)
    {
    	$data = $request->input();
    	$usedFontMap = $data['usedFontMap'];
    	$svg = $data['svg'];
    	$webpImage = $data['webpImage'];
    	$urlSegmentsFiltered = $data['urlSegmentsFiltered'];
    	$shopId = $urlSegmentsFiltered[0];
    	$templateId = $urlSegmentsFiltered[1];
    	$orderId = str_replace("#", "", $urlSegmentsFiltered[2]);

    	if(!$this->exists($shopId, $templateId, $orderId)){
			abort(404);
		}

		$logo = (new Logo())->where('brand_slug', $shopId)->get()[0];

    	$path = 'frontend\customisedTemplateSVGs\\' . time(). "_$orderId.svg";
    	$svgPath = storage_path("app\public\\$path");
    	$svgPath = str_replace("\\", '/', $svgPath);
    	$webpImagePath = str_replace(".svg", '.png', $svgPath);
		$webpImagePath = str_replace("\\", "/", $webpImagePath);

    	$this->base64_to_jpeg($webpImage, $webpImagePath);



    	if(((new ReadyToPrint())->where('order_id', $orderId)->get())->isEmpty()){
    	    $this->saveFile($svg, $svgPath);
			$readyToPrint = (new ReadyToPrint());
			$readyToPrint->template_id = $templateId;
			$readyToPrint->order_id = $orderId;
			$readyToPrint->image = $path;
			$readyToPrint->brand_name = $logo->brand_name;
			$readyToPrint->used_font_map = $usedFontMap;
			$readyToPrint->save();
			return ['message' => 'Order Recieved Successfully', 'status' => 'success', 'data' => ['readyToPrint' => $readyToPrint]];
    	}
    	else{
			return ['message' => 'Order Already exists', 'status' => 'success', 'data' => ''];

    	}
    }

    public function base64_to_jpeg($base64_string, $output_file) {
	    $ifp = fopen( $output_file, 'wb' ); 
	    $data = explode( ',', $base64_string );
	    fwrite( $ifp, base64_decode( $data[ 1 ] ) );
	    fclose( $ifp ); 
	    return $output_file; 
	}
}
