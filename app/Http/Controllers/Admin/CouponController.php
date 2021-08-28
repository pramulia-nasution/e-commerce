<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Coupons\CouponsRepository;

class CouponController extends Controller{

    public $coupon;
    function __construct(CouponsRepository $coupon){
        $this->coupon = $coupon;
    }

    public function index(){
        $header = [
            'title' => 'Kupon',
            'desc'  => 'List Kupon',
            'icon'  => 'fa-ticket'
        ];
        if(request()->ajax()){  
            $coupons = $this->coupon->pagingAllCoupons();
            return DataTables::of($coupons)
            ->addColumn('action',function($item){
                return '<a href="/admin/katalog/coupon/'.$item->id.'/edit" style="color:white;cursor:pointer" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a> '.
                '<a style="color:white;cursor:pointer" onclick="deleteData('.$item->id.',6)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
            })
            ->editColumn('coupon_total',function ($item){
                if($item->coupon_total == null)
                    return '~';
                else 
                    return $item->coupon_total;
            })
            ->editColumn('type',function($item){
                if($item->type == 'fixed_total')
                    return 'Potongan harga';
                else
                    return 'Potongan persen';
            })
            ->editColumn('amount',function ($item){
                if($item->type == 'fixed_total')
                    return rupiah($item->amount);
                else 
                    return persen($item->amount);
            })
            ->rawColumns(['action'])
            ->make(true); 
        }
        return view('admin.coupon.index',$header);
    }

    public function create(){
        $header = [
            'title' => 'Kupon',
            'desc'  => 'Tambah Kupon',
            'icon'  => 'fa-ticket'
        ];
        return view('admin.coupon.create',$header);
    }


    public function store(CouponRequest $request){
        $newData = $this->coupon->insertCoupon($request);
            return redirect()->route('admin.coupon.index')->with('success','Kupon baru berhasil ditambahkan');
        return redirect()->route('admin.coupon.index')->with('error','Terjadi kesalah saat input kupon baru');
    }


    public function edit($id){
        $header = [
            'title' => 'Kupon',
            'desc'  => 'Edit Kupon',
            'icon'  => 'fa-ticket'
        ];
        $coupon = $this->coupon->editCoupon($id);
        return view('admin.coupon.edit',$header)->with('coupon',$coupon);
    }

    public function update(CouponRequest $request, $id){
        $updateData = $this->coupon->updateCoupon($request,$id);
            return redirect()->route('admin.coupon.index')->with('success','Kupon berhasil diubah');
        return redirect()->route('admin.coupon.index')->with('error','Kupon gagal diubah');
    }

    public function destroy($id){
        $coupon = $this->coupon->deleteCoupon($id);
        if($coupon)
            return response()->json(['status'=>true],200);
    }
}
