<?php

namespace App\Http\Controllers\Admin;

use DataTables; 
use App\Http\Controllers\Controller;
use App\Repositories\Inventories\InventoriesRepository;


class InventoryController extends Controller{
    function __construct(InventoriesRepository $inventory){
        $this->inventory = $inventory;
    }
    public function index(){
        $header = [
            'title' => 'Stok Produk',
            'desc'  => 'List Stok Produk',
            'icon'  => 'fa-archive'
        ];
        if(request()->ajax()){
            $inventories = $this->inventory->pagingAllInvontories();
            return DataTables::of($inventories)
            ->addColumn('status', function($item){
                if($item->stock > $item->min_stock)
                    return '<span class="label bg-green">Tersedia</span>';
                elseif($item->stock == 0)
                    return '<span class="label bg-red">Kosong</span>';
                else
                    return '<span class="label bg-yellow">Limit</span>';
            })
            ->rawColumns(['status','action'])
            ->addColumn('action',function($item){
                return '<a href="/admin/katalog/inventory/'.$item->id.'/show" style="color:white;cursor:pointer" class="btn btn-info btn-sm" title="History Stok"><i class="fa fa-file-text"></i></a> '.
                '<a style="color:white;cursor:pointer" onclick="SetStock('.$item->id.',1)" class="btn btn-primary btn-sm" title="Update Stok"><i class="fa fa-refresh"></i></a>';
            })
            ->make(true);
        }
        return view('admin.inventory.index', $header);
    }
}
