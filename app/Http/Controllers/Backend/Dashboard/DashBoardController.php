<?php

namespace App\Http\Controllers\Backend\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Model\Mapping;
use App\Model\Font;
use App\Model\Template;
use App\Http\Requests\StoreTemplate;

class DashBoardController extends Controller
{
    public function index(Request $request)
    {
    	$fonts = (new Font())->get();
    	$mappings = (new Mapping())->get();
    	$mappingsIdMap = [];
    	$fontsIdMap = [];

    	foreach ($mappings as $key => $mapping) {
    		$mappingsIdMap[$mapping->id] = $mapping;
    	}

    	foreach ($fonts as $key => $font) {
    		$fontsIdMap[$font->id] = $font;
    	}
    	$templates = (new Template())->get();
    	return view('backend.dashboard.index', ['fonts' => $fonts, 'mappings' =>  $mappings, 'templates' =>  $templates, 'mappingsIdMap' => $mappingsIdMap, 'fontsIdMap' => $fontsIdMap]);
    }

    public function delete(Request $request)
    {
    	$id = $request->input('id');
    	if($id){
    		$template = (new Template())->find($id);
    		
    		$preview_image = storage_path('app\public'). "\\" . last(explode("storage/", $template->preview_image));
    		$preview_image = str_replace('\\', '/', $preview_image);
    		
    		$background_image = storage_path('app\public'). "\\" . last(explode("storage/", $template->background_image));
    		$background_image = str_replace('\\', '/', $background_image);
    		
    		$proof_image = storage_path('app\public'). "\\" . last(explode("storage/", $template->proof_image));
    		$proof_image = str_replace('\\', '/', $proof_image);
    		
    		unlink($preview_image);
            unlink($background_image);
            unlink($proof_image);
    		$template->delete();
    		return['message' => 'Template Deleted Successfully', 'data' => $template->toArray(), 'status' => "success"];
    	}
    	return['message' => 'Invalid request', 'data' => $template->toArray(), 'status' => "error"];
    }

    public function create(StoreTemplate $request)
    {
        $previewImage = $request->file('preview_image');
    	$backgroundImage = $request->file('background_image');
    	$proofImage = $request->file('proof_image');
    	$data = $request->input();
    	unset($data['_token']);
    	

    	//the template image is being stored in the storage/template
    	$data['preview_image'] = 'backend\template\previewImage\\' . $previewImage->getClientOriginalName(); 
    	$previewImagePath = storage_path("app\public\\" . $data['preview_image']);
    	$previewImagePath = str_replace('\\', '/', $previewImagePath);
    	$content = file_get_contents($previewImage->getRealPath());
        $this->saveFile($content, $previewImagePath);


    	$data['proof_image'] = 'backend\template\proofImage\\' . $proofImage->getClientOriginalName();
    	$proofImagePath = storage_path("app\public\\" . $data['proof_image']);
    	$proofImagePath = str_replace('\\', '/', $proofImagePath);
        $content = file_get_contents($proofImage->getRealPath());
        $this->saveFile($content, $proofImagePath);


    	$data['background_image'] = 'backend\template\backgroundImage\\' . $backgroundImage->getClientOriginalName();
    	$backgroundImagePath = storage_path("app\public\\" . $data['background_image']);
        $content = file_get_contents($backgroundImage->getRealPath());
        $backgroundImagePath = str_replace('\\', '/', $backgroundImagePath);
        $this->saveFile($content, $backgroundImagePath);

    	
        $templateObj = (new Template());
        $templateObj->firstOrCreate($data);
        $request->session()->flash('success', 'Template saved successfully'); 
        return ['message' => 'Template saved sccessfully', 'status' => 'success', 'data' => ['logo' => $templateObj->toArray()]];
    }

    public function saveFile($content, $destinationPath)
    {
        if(file_exists($destinationPath)){
            return false;
        }
    	return file_put_contents($destinationPath, $content);
    }
}
