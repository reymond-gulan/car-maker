<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

use App\Models\Manufacturers;
use App\Http\Requests\ManufacturerRequests;

class ManufacturersController extends Controller
{
    public function index()
    {
        $data = Manufacturers::orderBy('manufacturer_id','DESC')->get();

        return $data;
    }
    
    /**
     * Save manufacturer's data to the database
     *
     * @param ManufacturerRequests $request
     * @return array
     */

    public function save(ManufacturerRequests $request)
    {   
        
        $data = $request->validated();

        DB::beginTransaction();
        
        try {

            Manufacturers::create($data);

            DB::commit();

            return response()->json(['success' => 'Saved!']);
            
        } catch(QueryException $e) {

            DB::rollback();

            return response()->json(['error' => $e->errorInfo[2]]);
        }
    }

    /**
     * Delete given data from database
     *
     * @param Manufacturers $manufacturer
     *
     * @return array
     *
     */
    public function destroy(Manufacturers $manufacturer)
    {
        try {
            
            $manufacturer->delete();
            return response()->json(['success' => 'Database record has been deleted.']);

        } catch(QueryException $e) {
            return response()->json(['error' => $e->errorInfo[2]]);
        }
    }
}
