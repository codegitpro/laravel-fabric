<?php

namespace App\Http\Controllers\Backend\Fonts;

use App\Helper\Common;
use App\Http\Controllers\Controller as Controller;
use App\Http\Requests\StoreFonts;
use App\Model\Font;
use Illuminate\Http\Request;

class FontsController extends Controller
{
    public function index(Request $request)
    {
        $fonts = (new Font())->get();
        return view('backend.fonts.index', ['fonts' => $fonts]);
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        if ($id) {
            $font = (new Font())->find($id);
            $path = public_path($font->path);
            $path = str_replace('\\', '/', $path);
            unlink($path);
            $font->delete();
            $request->session()->flash('Font Deleted Successfully');
            return ['message' => 'Font Deleted Successfully', 'data' => $font->toArray(), 'status' => "success"];
        }
        $request->session()->flash('Invalid request');
        return ['message' => 'Invalid request', 'data' => (new Font())->toArray(), 'status' => "error"];
    }

    // public function create(Request $request)
    public function create(StoreFonts $request)
    {
        $file = $request->file('font_file');
        if ($file->getClientOriginalExtension() != 'ttf') {
            $request->session()->flash('error', 'Invalid file type, ttf required');
            return ['message' => 'Invalid file type, ttf required', 'status' => 'error', 'data' => ''];
        }

        $data['edited_name'] = $request->input('edited_name');
        $data['name'] = (new Common())->unSlugify(str_replace(".ttf", "", $file->getClientOriginalName()));
        $data['slug'] = (new Common())->slugify($data['name']);
        $data['path'] = 'backend\Fonts\Mont\\' . $file->getClientOriginalName();
        $data['active'] = 1;

        $path = public_path($data['path']);
        $path = str_replace('\\', '/', $path);
        $content = file_get_contents($file->getRealPath());
        $fontObj = new Font();

        if (!$this->saveFile($content, $path)) {
            $request->session()->flash('error', 'Font file already exists. Please delete it before uploading again.');
            return ['message' => 'Font file already exists. Please delete it before uploading again.', 'status' => 'success', 'data' => ['font' => $fontObj->toArray()]];
        }

        $fontObj->firstOrCreate($data);
        $request->session()->flash('success', 'Font saved successfully');
        return ['message' => 'Font saved sccessfully', 'status' => 'success', 'data' => ['font' => $fontObj->toArray()]];
    }

    public function saveFile($content, $destinationPath)
    {
        return file_exists($destinationPath) ? false : file_put_contents($destinationPath, $content);
    }

    public function search(Request $request)
    {
        $fonts = Font::where('name', 'like', '%' . $request->get('search_font') . '%')
                     ->get();
        return view('backend.fonts.index', ['fonts' => $fonts]);
    }
}
