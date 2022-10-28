<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

use App\Models\Manufacturers;
use App\Models\Cars;

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
     * @param Request $request
     * @return array
     */

    public function save(Request $request)
    {
        $message = '';

        $rules = array(
            'manufacturer_id' => ['required'],
            'car_name' => ['required','string', 'max:255'],
        );

        $error  = Validator::make($request->all(),$rules);
            
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        
        $data = [
            'manufacturer_id' => $request->get('manufacturer_id'),
            'car_name' => $request->get('car_name')
        ];

        try {

            $manufacturers = Manufacturers::findOrFail($data['manufacturer_id']);
            
            $manufacturers->cars()->create($data);

            $message = 'New record has been saved';

            return response()->json(['success' => $message]);

        } catch(QueryException $e) {
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
