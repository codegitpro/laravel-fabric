<?php

namespace App\Http\Controllers\Backend\Mapping;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Helper\Common;
use App\Http\Requests\StoreMapping;
use App\Model\Mapping;

class MappingController extends Controller
{
    public function index(Request $request)
    {
    	$mappings = (new Mapping())->get();
    	return view('backend.mapping.index', ['mappings' => $mappings]);
    }

    public function delete(Request $request)
    {
    	$id = $request->input('id');
    	if($id){
    		$mapping = (new Mapping())->find($id);
    		$product_background = storage_path('app\public'). "\\" . last(explode("storage/", $mapping->product_background));
    		$product_background = str_replace("\\", "/", $product_background);
    		$mappingObject = $mapping->toArray();
    		unlink($product_background);
    		$mapping->delete();
    		return['message' => 'Mapping Deleted Successfully', 'data' => $mappingObject, 'status' => "success"];
    	}
    	return['message' => 'Invalid request', 'data' => $mapping->toArray(), 'status' => "error"];
    }

    public function create(StoreMapping $request)
    {
    	$file = $request->file('product_image_file');
    	$data = $request->input();
    	unset($data['_token']);
    	$data['product_slug'] = (new Common())->slugify($data['product_name']);
    	$data['product_background'] = 'backend\mappings\\' . $file->getClientOriginalName(); //the logo image is being stired in the storage/mappings

        $path = storage_path("app\public\\" . $data['product_background']);
        $path = str_replace("\\", "/", $path);
        $content = file_get_contents($file->getRealPath());
        $mappingObj = (new Mapping());
        if($this->saveFile($content, $path)){
            $mappingObj->firstOrCreate($data);
        }
        else{
            $request->session()->flash('error', 'Mapping already exists. Please delete it before uploading again.'); 
            return ['message' => 'Mapping already exists. Please delete it before uploading again.', 'status' => 'success', 'data' => ['logo' => $mappingObj->toArray()]];
        }

        $request->session()->flash('success', 'Mapping saved successfully'); 
        return ['message' => 'Mapping saved sccessfully', 'status' => 'success', 'data' => ['logo' => $mappingObj->toArray()]];
    }

    public function saveFile($content, $destinationPath)
    {
        if(file_exists($destinationPath)){
            return false;
        }
    	return file_put_contents($destinationPath, $content);
    }
}
