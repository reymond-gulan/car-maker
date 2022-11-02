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
use App\Classes\ManufacturersHelper;

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

            $manufacturers = ManufacturersHelper::manufacturer($data);
            
            $manufacturers->cars()->create($data);

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
        return Cars::with('manufacturers')->find($id);
    }

    /**
     * Update specified data
     *
     * @param CarRequests $request, int $id
     *
     * @return void
     *
     */
    public function update(CarRequests $request, $id)
    {
        $data = $request->validated();
        
        DB::beginTransaction();

        try {

            ManufacturersHelper::manufacturer($data);
            
            Cars::find($id)->update($data);

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
