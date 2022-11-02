<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

use App\Models\Manufacturers;
use App\Models\Cars;
use App\Http\Requests\CarRequests;

class CarsController extends Controller
{
    public function index()
    {
        $data = Cars::with('manufacturers')->orderBy('car_id','DESC')->get();

        return $data;
    }
    
    /**
     * Save data to the database
     *
     * @param CarRequests $request
     * @return array
     */

    public function save(CarRequests $request)
    {
        $data = $request->validated();
        
        DB::beginTransaction();

        try {

            $manufacturers = Manufacturers::findOrFail($data['manufacturer_id']);
            
            $manufacturers->cars()->create($data);

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
     * @param Cars $cars
     *
     * @return array
     *
     */
    public function destroy(Cars $cars)
    {
        try {
            
            $cars->delete();
            return response()->json(['success' => 'Database record has been deleted.']);

        } catch(QueryException $e) {
            return response()->json(['error' => $e->errorInfo[2]]);
        }
    }
}
