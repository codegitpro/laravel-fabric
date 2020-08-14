<?php

namespace App\Http\Controllers\Backend\Logo;

use App\Helper\Common;
use App\Http\Controllers\Controller as Controller;
use App\Http\Requests\StoreLogo;
use App\Model\Logo;
use Illuminate\Http\Request;

class LogoController extends Controller
{
    public function index(Request $request)
    {
        $logos = (new Logo())->get();
        return view('backend.logo.index', ['logos' => $logos]);
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        if ($id) {
            $logo = (new Logo())->find($id);
            $brand_logo = storage_path('app\public') . "\\" . last(explode("storage/", $logo->brand_logo));
            $brand_logo = str_replace('\\', '/', $brand_logo);
            unlink($brand_logo);
            $logo->delete();
            return ['message' => 'Logo Deleted Successfully', 'data' => $logo->toArray(), 'status' => "success"];
        }
        return ['message' => 'Invalid request', 'data' => $logo->toArray(), 'status' => "error"];
    }

    public function create(StoreLogo $request)
    {
        $file = $request->file('logo_file');
        $data = $request->input();
        unset($data['_token']);
        $data['brand_logo'] = 'backend\logos\\' . $file->getClientOriginalName(); //the logo image is being stired in the storage/logos
        $data['brand_slug'] = (new Common())->slugify($data['brand_name']);
        $path = storage_path("app\public\\" . $data['brand_logo']);
        $path = str_replace('\\', '/', $path);
        $content = file_get_contents($file->getRealPath());
        $logoObj = (new Logo());
        if (!$this->saveFile($content, $path)) {
            $request->session()->flash('error', 'Logo file already exists. Please delete it before uploading again.');
            return [
                'message' => 'Logo file already exists. Please delete it before uploading again.',
                'status' => 'success',
                'data' => ['logo' => $logoObj->toArray()]
            ];
        }

        $logoObj->firstOrCreate($data);

        $request->session()->flash('success', 'Logo saved successfully');
        return [
            'message' => 'Logo saved sccessfully',
            'status' => 'success',
            'data' => ['logo' => $logoObj->toArray()]
        ];
    }

    public function saveFile($content, $destinationPath)
    {
        if (file_exists($destinationPath)) {
            return false;
        }
        return file_put_contents($destinationPath, $content);
    }

    public function search(Request $request)
    {
        $logos = Logo::where('brand_name', 'like', '%' . $request->get('search_logo') . '%')
                     ->get();
        return view('backend.logo.index', ['logos' => $logos]);
    }
}
