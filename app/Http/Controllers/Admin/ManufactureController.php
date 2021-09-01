<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\ManufacutureRequest;
use App\Repositories\Images\ImagesRepository;
use App\Repositories\Manufactures\ManufacturesRepository;

class ManufactureController extends Controller
{
    public $manufacture;

    function __construct(ManufacturesRepository $manufacture, ImagesRepository $image){
        $this->manufacture = $manufacture;
        $this->image = $image;
    }

    public function index()
    {
        $header = [
            'title' => 'Brand',
            'desc'  => 'Daftar Brand',
            'icon'  => 'fa-industry'
        ];
        if(request()->ajax()){
            $manufactures = $this->manufacture->pagingAllMaufactures();
            return DataTables::of($manufactures)
            ->editColumn('path',function ($item){
                return '<img width="100px" src="/'.$item->path.'">';
            })
            ->addColumn('action',function($item){
                return '<a href="/admin/katalog/manufacture/'.$item->id.'/edit" style="color:white;cursor:pointer" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a> '.
                '<a style="color:white;cursor:pointer" onclick="deleteData('.$item->id.',1)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['path','action'])
            ->make(true);
        }
        return view('admin.manufacture.index',$header);
    }

    public function create()
    {
        $header = [
            'title' => 'Brand',
            'desc'  => 'Tambah Brand',
            'icon'  => 'fa-industry'
        ];
        $images = $this->image->getAllThumbnails();
        return view('admin.manufacture.create',$header)->with('images',$images);
    }

    public function store(ManufacutureRequest $request)
    {
        $newData = $this->manufacture->insertManufacture($request);
            return redirect()->route('admin.manufacture.index')->with('success','Brand baru berhasil ditambahkan');
        return redirect()->route('admin.manufacture.index')->with('error','Terjadi kesalahan saat input Brand baru');
    }

    public function edit($id){
        $header = [
            'title' => 'Brand',
            'desc'  => 'Edit Brand',
            'icon'  => 'fa-industry'
        ];
        $manufacture = $this->manufacture->editManufacture($id);
        $images = $this->image->getAllThumbnails();
        return view('admin.manufacture.edit',$header)->with('images',$images)->with('manufacture',$manufacture);
    }

    public function update(ManufacutureRequest $request, $id){
        $updateData = $this->manufacture->updateManufacture($request,$id);
            return redirect()->route('admin.manufacture.index')->with('success','Brand berhasil diubah');
        return redirect()->route('admin.manufacture.index')->with('error','Brand gagal diubah');
    }

    public function destroy($id){
        $manufacture = $this->manufacture->deleteManufacture($id);
        if($manufacture)
            return response()->json(['params'=>'Brand','data' => $manufacture],200);
    }
}
