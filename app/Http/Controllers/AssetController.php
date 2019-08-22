<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreAssetRequest;

use Yajra\Datatables\Datatables;
use Carbon\Carbon;

use App\Asset;
class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('asset.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('asset.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAssetRequest $request)
    {
        $asset = new Asset;
        $asset->asset_category_id = $request->asset_category_id;
        $asset->code = time();
        $asset->name = $request->name;
        $asset->price = $request->price;
        $asset->type = $request->type;
        $asset->description = $request->description;
        $asset->save();
        return redirect('master-data/asset')
        ->with('success-message', "Asset has been created");
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


    //ASSETS datatables
    public function dataTables(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $assets = Asset::with('asset_category')->select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'assets.*',
        ])->get();

        $data_asset = Datatables::of($assets)
            ->editColumn('asset_category', function($assets){
                if($assets->asset_category){
                    return $assets->asset_category->name;
                }else{
                    return "";
                }
                
            })
            ->editColumn('type', function($assets){
                return asset_type_display($assets->type);
            })
            ->editColumn('price', function($assets){
                return number_format($assets->price,2);
            })
            ->addColumn('actions', function($assets){
                    $actions_html ='<a href="'.url('asset-category/'.$assets->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('asset-category/'.$assets->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this asset-category">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-asset-category" data-id="'.$assets->id.'" data-text="'.$assets->name.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_asset->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_asset->make(true);
    }
    //END ASSETS datatables
}
