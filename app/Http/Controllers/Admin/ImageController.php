<?php

namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use App\Services\ImageService;
use App\Http\Controllers\Controller;
use App\Repositories\Images\ImagesRepository;
use App\Repositories\Settings\SettingsRepository;

class ImageController extends Controller
{
    public $image;
    public $setting;
    private $thumbnail;
    private $medium;
    private $large;
    function __construct(ImagesRepository $image, SettingsRepository $setting, ImageService $imageService){
        $this->image = $image;
        $this->setting = $setting;
        $this->imageService = $imageService;
        $this->thumbnail = $this->setting->getThumbnailSize();
        $this->medium = $this->setting->getMediumSize();
        $this->large = $this->setting->getLargeSize();
    }
    
    public function index(){
        $header = [
            'title' => 'Gambar',
            'desc'  => 'Daftar semua gambar',
            'icon'  => 'fa-picture-o'
        ];
        $images = $this->image->getAllThumbnails();
        return view('admin.image.index',$header)->with('images',$images);
    }

    public function settings(){
        $header = [
            'title' => 'Pengaturan Gambar',
            'desc'  => 'Pengaturan Ukuran Gambar',
            'icon'  => 'fa-picture-o'
        ];
        return view('admin.image.settings',$header);
    }

    public function getSizeImage(){
        return response()->json([
            'status' => 'success',
            'data' => [
                'thumbnail' => $this->thumbnail,
                'medium' => $this->medium,
                'large' => $this->large
            ]
        ]);
    }

    public function postSizeImage(Request $request){
        DB::beginTransaction();
        try{
           $data = $this->setting->setSizeImages($request);
            DB::commit();
            return response()->json(['status' => 'success','data' => $data],200);
        }
        catch(\Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error','data' => $e->getMessage()],500);
        }
    }

    public function store(Request $request){
        $image = $request->file('file');
        $this->imageService->makeImages($image);
        return; 
    }

    public function show($id){
        $header = [
            'title' => 'Gambar',
            'desc'  => 'Detail gambar',
            'icon'  => 'fa-picture-o'
        ];
        $images = $this->image->detailImage($id);
        return view('admin.image.show',$header)->with(['images' => $images]);
    }

    public function regenerate(Request $request){
        $images = $this->image->regenerate($request);
        if ($images)
            return redirect()->back()->with('success','Ukuran gambar berhasil diubah');
        return redirect()->back()->with('error','ukuran gambar gagal diubah');
    }

    public function destroy(Request $request){
        $images = $this->image->deleteImages($request);
        if($images)
            return response()->json(['data' => $images],200);
    }
}
