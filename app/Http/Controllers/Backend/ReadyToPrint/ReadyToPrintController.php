<?php

namespace App\Http\Controllers\Backend\ReadyToPrint;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Model\ReadyToPrint;
use App\Model\Template;
use TCPDF;
use TCPDF_FONTS;
use TCPDF_COLORS;

class ReadyToPrintController extends Controller
{
	public function index(Request $request)
	{
		$readyToPrint = (new ReadyToPrint())->get();
		// dd($readyToPrint->toArray());
		$templateIds = $readyToPrint->pluck('template_id')->toArray();
		$template = (new Template())->whereIn('template_custom_id', $templateIds)->get();
		$templateCustomIdMap = $template->mapWithKeys(function ($item) {
			return [$item['template_custom_id'] => $item];
		});
		return view('backend.readyToPrint.index', ['readyToPrint' => $readyToPrint, 'templateCustomIdMap' => $templateCustomIdMap]);
	}

	public function downloadPdf(Request $request, $orderId)
	{
		$readyToPrint = (new ReadyToPrint())->where('order_id', $orderId)->get();
		$readyToPrint = isset($readyToPrint[0]) ? $readyToPrint[0] : abort(404);
		$usedFontMap = $readyToPrint->used_font_map;
		$usedFontMap = json_decode($usedFontMap, true);

		$path = public_path("storage/$readyToPrint->originalUrl");
		$path = str_replace("\\", "/", $path);
		
		$svg = file_get_contents($path);
		
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->AddPage();
		$svg = $this->updateSvgCustomFontPaths($svg, $usedFontMap, $request, $pdf);
		$svgNewPath = $this->updateSvgEmbeddUrls($svg, $request); // passed the svg text to change image url inside svg
		
		$alreadyAdded = false;
		if(strpos($svg, '</image>') == false){
			// $pdf->ImageSVG($file=$svgNewPath, $x=15, $y=30, $w='', $h='', 'RDB_WHITE', $fitonpage=false);
			$alreadyAdded = true;
			TCPDF_COLORS::$spotcolor['RDB_WHITE'] = array( 52, 47, 81, 100, 'RDB_WHITE');
			$pdf->AddSpotColor('RDG_WHITE', 0, 100, 100, 0);
			// $pdf->SetTextSpotColor('RDG_WHITE', 100);
			
			// $pdf->SetDrawSpotColor('RDG_WHITE', 100);

			// $starty = 100;

			// print some spot colors

			$pdf->SetFillSpotColor('RDG_WHITE', 100);


			// $pngFile = str_replace(".svg", ".png", $svgNewPath);
			// $pdf->Image($pngFile, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=true, $imgmask=true, $border=0, $fitbox=false, $hidden=false, $fitonpage=false, $alt=false, $altimgs=array());
			$pdf->ImageSVG($file=$svgNewPath, $x=15, $y=30, $w='', $h='', $fitonpage=false);
			
		}

		if(!$alreadyAdded)
			$pdf->ImageSVG($file=$svgNewPath, $x=15, $y=30, $w='', $h='', $fitonpage=false);


		$pdf->SetY(195);
		$pdf->Output("$orderId.pdf", 'D');
		unlink($svgNewPath);
	}

	public function updateSvgEmbeddUrls($svg, $request)
	{
		$root = str_replace("\\", "/", $request->root());
		$publicPath = str_replace("\\", "/", public_path());
		$svg1 = str_replace($root, $publicPath, $svg);
		$svg1 = str_replace('public/public', 'public', $svg);
		$tempPath = public_path('storage\\'.uniqid() . '.svg');
		file_put_contents($tempPath, $svg1);
		return $tempPath;
	}

	public function updateSvgCustomFontPaths($svg, $usedFontMap, $request, &$pdf)
	{
		if(empty($usedFontMap)){
			foreach ($usedFontMap as $fontFamily => $url) {
				$relativeUrl = $url;
				$root = str_replace("\\", "/", $request->root());
				$publicPath = str_replace("\\", "/", public_path());
				$relativeUrl = str_replace($root, $publicPath, $url);
				$fontname = TCPDF_FONTS::addTTFfont($relativeUrl, 'TrueTypeUnicode', '', 96);
				$svg = str_replace("fontFamily", "$fontname", $svg);
				$pdf->SetFont($fontname, '', 10);
				return $svg;
			}
		}
		return $svg;
	}
}
