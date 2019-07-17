<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Yajra\Datatables\Datatables;
use Carbon\Carbon;
//User Maatwebsite Excel package
use Excel;

use App\ProductCategory;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('product-category.index');
    }

    //return dataTables
    public function dataTables(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $product_category = ProductCategory::select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'product_categories.*',
        ])->get();

        $data = Datatables::of($product_category)
            ->addColumn('actions', function($product_category){
                    $actions_html ='<a href="'.url('product/'.$product_category->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('product/'.$product_category->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this product">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    /*$actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-product" data-id="'.$product_category->id.'" data-text="'.$product_category->name.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';
                    */

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    //Import file 
    public function import(Request $request)
    {
        if($request->hasFile('file')){
            
            config(['excel.import.startRow' => 2]);
            $path = $request->file('file')->getRealPath();
            $data = Excel::load($path, function($reader){
                    })->get();
            //dd($data);

            if(!empty($data) && $data->count()){
                foreach ($data as $key => $value){
                    //create the resource if the record based on the inputs doesn't exists
                    //otherwise just take it / or return it
                    $product_category = ProductCategory::firstOrCreate(['code'=>$value->code, 'name'=>$value->name]);
                }
            
            }
            return back()
            ->with('successMessage', "Data has been imported");
        }
        else{
            return redirect()->back()
            ->with('errorMessage', "No file to be imported");
        }
    }
}
