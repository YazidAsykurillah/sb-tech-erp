<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests;
use App\Http\Requests\StoreAssetCategoryRequest;

use Yajra\Datatables\Datatables;
use Carbon\Carbon;

use App\AssetCategory;
class AssetCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('asset-category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('asset-category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAssetCategoryRequest $request)
    {
        $data = [
            'name'=>$request->name,
            'description'=>$request->description,
        ];
        $save = AssetCategory::create($data);
        return redirect('master-data/asset-category')
            ->with('successMessage', "AssetCategory has been created");
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


    //ASSETS CATEGORIES datatables
    public function dataTables(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $asset_categories = AssetCategory::select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'name',
            'description'
        ]);

        $data_asset_categories = Datatables::of($asset_categories)
            ->addColumn('actions', function($asset_categories){
                    $actions_html ='<a href="'.url('asset-category/'.$asset_categories->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('asset-category/'.$asset_categories->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this asset-category">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-asset-category" data-id="'.$asset_categories->id.'" data-text="'.$asset_categories->name.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_asset_categories->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_asset_categories->make(true);
    }
    //END ASSETS CATEGORIES datatables
}
