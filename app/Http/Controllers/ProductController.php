<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
//User Maatwebsite Excel package
use Excel;

use App\Http\Requests;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

use App\Product;
use App\ProductCategory;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('product.index');
    }

    //return dataTables
    public function dataTables(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $products = Product::select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'products.*',
        ])->get();

        $data_product = Datatables::of($products)
            ->editColumn('price', function($products){
                return number_format($products->price);
            })
            ->addColumn('actions', function($products){
                    $actions_html ='<a href="'.url('product/'.$products->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('product/'.$products->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this product">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    /*$actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-product" data-id="'.$products->id.'" data-text="'.$products->name.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';
                    */

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_product->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_product->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $product = new Product;
        $product->code = $request->code;
        $product->name = $request->name;
        $product->unit = $request->unit;
        //$product->initial_stock = $request->initial_stock ? $request->initial_stock : 0;
        $product->stock = $request->stock ? $request->stock : 0;
        $product->save();
        return redirect('product')
            ->with('successMessage', "Product $request->name has been stored");
    }

    /*
    ####Back UP###
    public function importExcel(Request $request)
    {
        if($request->hasFile('file')){
            
            config(['excel.import.startRow' => 1]);
            $path = $request->file('file')->getRealPath();
            $data = Excel::load($path, function($reader){
                    })->get();
            
            if(!empty($data) && $data->count()){
                $insert = [];
                foreach ($data as $key => $value){
                    $insert[] = [
                        'code'=>$value->code,
                        'name'=>$value->name,
                        'unit'=>$value->unit,
                        'price'=>$value->price,
                        //'initial_stock'=>$value->initial_stock,
                        'stock'=>$value->stock,
                    ];
                }
            
                if(!empty($insert)){
                    \DB::table('products')->insert($insert);
                    //dd('Insert Record successfully.');
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
    */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrfail($id);
        return view('product.show')
            ->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrfail($id);
        return view('product.edit')
            ->with('product', $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrfail($id);
        $product->code = $request->code;
        $product->name = $request->name;
        $product->unit = $request->unit;
        $product->stock = $request->stock ? $request->stock : 0;
        $product->save();
        return redirect('product')
            ->with('successMessage', "Product $request->name has been stored");
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


    public function importExcel(Request $request)
    {
        if($request->hasFile('file')){
            
            config(['excel.import.startRow' => 2]);
            $path = $request->file('file')->getRealPath();
            $data = Excel::load($path, function($reader){
                    })->get();
            //dd($data);
            if(!empty($data) && $data->count()){
                foreach ($data as $key => $value){
                    $insert = [
                        'code'=>$value->code,
                        'product_category_id'=>$this->getProductCategoryId($value->product_category_code),
                        'name'=>$value->name,
                        'unit'=>$value->unit,
                        'price'=>$value->price,
                        'part_number'=>$value->part_number,
                        'brand'=>$value->brand,
                        'stock'=>$value->stock,
                    ];
                    $product = Product::firstOrCreate($insert);
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

    //retrurn product category id or null
    protected function getProductCategoryId($code)
    {
        $result = NULL;
        $product_category = ProductCategory::where('code', 'LIKE', "%$code%")->first();
        if($product_category){
            $result = $product_category->id;
        }
        return $result;

    }
    
}
