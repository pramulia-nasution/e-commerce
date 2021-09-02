<?php

namespace App\Http\Controllers\Admin;

use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Images\ImagesRepository;
use App\Repositories\Categories\CategoriesRepository;

class CategoryController extends Controller{
    public $category;
    public $image;
    function __construct(CategoriesRepository $category, ImagesRepository $image, CategoryService $categoryService){
        $this->categoryService = $categoryService;
        $this->category = $category;
        $this->image = $image;
    }

    public function index(){
        $header = [
            'title' => 'Kategori',
            'desc'  => 'Daftar Kategori',
            'icon'  => 'fa-list'
        ];
        if(request()->ajax()){
            $categories = $this->category->pagingAllCategories();
            return DataTables::of($categories)
            ->editColumn('status',function ($item){
                if($item->status == 0)
                    return '<span class="label bg-orange">Draft</span>';
                else
                    return '<span class="label bg-green">Publish</span>';
            })
            ->editColumn('path',function ($item){
                return '<img width="70px" src="/'.$item->path.'">';
            })
            ->addColumn('action',function($item){
                return '<a href="/admin/katalog/category/'.$item->id.'/edit" style="color:white;cursor:pointer" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a> '.
                '<a style="color:white;cursor:pointer" onclick="deleteData('.$item->id.',2)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['status','action','path'])
            ->make(true);
        }
        return view('admin.category.index',$header);
    }

    public function create(){
        $header = [
            'title' => 'Kategori',
            'desc'  => 'Tambah Kategori',
            'icon'  => 'fa-industry'
        ];
        $images = $this->image->getAllThumbnails();
        $option = $this->categoryService->htmlCategory();
        return view('admin.category.create',$header)->with('images',$images)->with('option',$option);
    }

    public function store(CategoryRequest $request){
        $newData = $this->category->insertCategory($request);
        if($newData)
            return redirect()->route('admin.category.index')->with('success','Kategori baru berhasil ditambahkan');
        return redirect()->route('admin.category.index')->with('error','Terjadi kesalah saat input Kategori baru');
    }

    public function edit($id){
        $header = [
            'title' => 'Kategori',
            'desc'  => 'Edit Kategori',
            'icon'  => 'fa-industry'
        ];
        $images = $this->image->getAllThumbnails();
        $category = $this->category->editCategory($id);
        $option = $this->categoryService->htmlCategory($category->id, $category->parent_id);
        return view('admin.category.edit',$header)->with(['images' => $images, 'option' => $option, 'category' => $category]);   
    }

    public function update(CategoryRequest $request, $id){
        $updateData = $this->category->updateCategory($request,$id);
        if($updateData)
            return redirect()->route('admin.category.index')->with('success','Kategori berhasil diubah');
        return redirect()->route('admin.category.index')->with('error','Kategori gagal diubah');

    }

    public function destroy($id){
        $category = $this->category->deleteCategory($id);
        if($category)
            return response()->json(['params'=>'Kategori','data' => $category],200);
    }
}
