<?php

namespace App\Http\Controllers;

use App\Models\deptList;
use App\Models\assetCode;
use Illuminate\Http\Request;
use App\Http\Requests\StoreassetCodeRequest;
use App\Http\Requests\UpdateassetCodeRequest;

class AssetCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('assetcode', [
            'data' => assetCode::all(),
            'dept' => deptList::all()
        ]);
    }

    public function create(Request $request)
    {
        try{

            $request->validate([
                'asset_code' => 'required',
                'dept_code' => 'required'
            ]);

            assetCode::create([
                'asset_code' => $request->asset_code,
                'dept_code' => $request->dept_code
            ]);

            return response()->json(['message' => 'New Account Successfully added']);

        }catch(\Exception $e){

            return response()->json(['error' => 'Failed to Create New Account'], 500);

        }
    }

    public function delete_asset($id)
    {
        try{
            $asset = assetCode::findOrFail($id);
            $asset->delete();

            return response()->json(['message' => 'assetCode successfully deleted']);

        } catch (\Exception $e){
            return response()->json(['error' => 'assetCode delete failed'], 500);
        }
    }


}
