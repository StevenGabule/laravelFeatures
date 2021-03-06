<?php

namespace App\Http\Controllers;

use App\Sample_data;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SampleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Sample_data::latest()->get();
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="' . $data->id . '" class="delete btn btn-danger btn-sm">Delete</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('sample_data');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required'
        );

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name
        );

        Sample_data::create($form_data);
        return response()->json(['success' => 'Data Added successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param Sample_data $sample_data
     * @return Response
     */
    public function show(Sample_data $sample_data)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Sample_data $sample_data
     * @return Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Sample_data::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Sample_data $sample_data
     * @return Response
     */
    public function update(Request $request, Sample_data $sample_data)
    {
        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required'
        );

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name
        );

        Sample_data::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Data is successfully updated!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return void
     */
    public function destroy($id)
    {
        $data = Sample_data::findOrFail($id);
        $data->delete();
    }
}
