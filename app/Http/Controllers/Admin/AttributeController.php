<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Attributes\AttributesRepository;

class AttributeController extends Controller{
    public $attribute;
    function __construct(AttributesRepository $attribute){
        $this->attribute = $attribute;
    }
    public function index(){
        $header = [
            'title' => 'Atribut',
            'desc'  => 'Daftar Atribut',
            'icon'  => 'fa-folder'
        ];
        if(request()->ajax()){
            $attributes = $this->attribute->pagingAllAttributes();
            return DataTables::of($attributes)
            ->editColumn('name',function ($item){
                return $item->name.'<a style="color:#00c0ef;cursor:pointer" onclick="tambahValue('.$item->id.')"> <i class="fa fa-plus"></i></a>';
            })
            ->editColumn('options', function ($item){
                return $item->options->map(function ($option){
                    return '<li style="font-weight:900">'.$option->value.'<a style="color:blue;cursor:pointer" onclick="editValue('.$option->id.')"> <i class="fa fa-pencil"></i></a> | <a onclick="deleteData('.$option->id.',4)" style="color:red;cursor:pointer"> <i class="fa fa-trash"></i></a></li>';
                })->implode('');
            })
            ->addColumn('action',function($item){
                return '<a style="color:white;cursor:pointer" onclick="deleteData('.$item->id.',3)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['name','options','action'])
            ->make(true);   

        }
        return view('admin.attribute.index',$header);
    }

    public function create(){
        $header = [
            'title' => 'Atribut',
            'desc'  => 'Tambah Atribut',
            'icon'  => 'fa-folder'
        ];
        return view('admin.attribute.create',$header);
    }

    public function store(AttributeRequest $request){
        $newData = $this->attribute->insertAttribute($request);
            return redirect()->route('admin.attribute.index')->with('success','Atribut baru berhasil ditambahkan');
        return redirect()->route('admin.attribute.index')->with('error','Terjadi kesalahan saat input Atribut baru');
    }

    public function destroy($id){
        $atribut = $this->attribute->deleteAttribute($id);
        if($atribut)
            return response()->json(['params'=>'Nilai atribut','data' => $atribut],200);
    }

    public function storeValue(){
        $Data = $this->attribute->ChangeAttributes(request());
        if($Data)
            return response()->json(['status' => true],200);
    }

    public function editValue($id){
        $editData = $this->attribute->editValue($id);
        if($editData)
            return response()->json(['status' => true, 'data' =>$editData],200);
    }

    public function destroyValue($id){
        $value = $this->attribute->deleteValue($id);
        if($value)
            return response()->json(['params'=>'Nilai','data' => $value],200);
    }
}
