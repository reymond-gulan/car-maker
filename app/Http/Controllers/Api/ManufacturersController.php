<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

use App\Models\Manufacturers;
use App\Http\Requests\ManufacturerRequests;
use App\Classes\ManufacturersHelper;

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
     * Show specified data
     *
     * @param int $id
     *
     * @return array
     *
     */
    public function show($id)
    {
        $data['manufacturer_id'] = $id;

        return ManufacturersHelper::manufacturer($data);
    }

    /**
     * Update specified data
     *
     * @param ManufacturerRequests $request, int $id
     *
     * @return void
     *
     */
    public function update(ManufacturerRequests $request, $id)
    {
        $data = $request->validated();
        
        DB::beginTransaction();

        try {
            $data['manufacturer_id'] = $id;
            
            $manufacturer = ManufacturersHelper::manufacturer($data);
            
            $manufacturer->update($data);

            DB::commit();

            return response()->json(['success' => true]);

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
