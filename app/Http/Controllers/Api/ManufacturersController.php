<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

use App\Models\Manufacturers;

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
     * @param Request $request
     * @return array
     */

    public function save(Request $request)
    {
        $message = '';

        $rules = array(
            'manufacturer' => ['required'],
            'type' => ['required'],
            'color' => [
                    'required',
                    'regex:/^#[a-zA-Z0-9]{6}$/i'
                        ],
        );

        $error  = Validator::make($request->all(),$rules);
            
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        
        $data = [
            'manufacturer' => $request->get('manufacturer'),
            'type' => $request->get('type'),
            'color' => $request->get('color')
        ];

        try {

            Manufacturers::create($data);
            $message = 'New record has been saved';

            return response()->json(['success' => $message]);

        } catch(QueryException $e) {
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
