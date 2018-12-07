<?php

namespace App\Http\Controllers;

use App\Operation;
use Illuminate\Http\Request;

class OperationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $operation = new Operation;
        $operation->operation_date    = $request->get('date');
        $operation->balance           = $request->get('remainder');
        $operation->sum               = $request->get('sum');
        $operation->details           = $request->get('description');
        $operation->type_operation_id = $request->get('type');
        $operation->author_id         = $request->get('author_id');
        $operation->save();

        return response()->json([
            "operation" => $operation
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Operation  $operation
     * @return \Illuminate\Http\Response
     */
    public function show(Operation $operation, $id)
    {
        $operation = \App\Operation::where('id', '=', $id)->first();
        return response()->json([
            'id' => $id,
            'operation' => $operation
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Operation  $operation
     * @return \Illuminate\Http\Response
     */
    public function edit(Operation $operation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Operation  $operation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Operation $operation, $id)
    {
        $operation = \App\Operation::where('id', '=', $id)->first();
        
        $operation->operation_date    = $request->get('date');
        $operation->balance           = $request->get('remainder');
        $operation->sum               = $request->get('sum');
        $operation->details           = $request->get('description');
        $operation->type_operation_id = $request->get('type');
        $operation->author_id         = $request->get('author_id');
        
        $operation->save();
        return response()->json([
            'operation' => $operation
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Operation  $operation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Operation $operation, $id)
    {
        $operation = \App\Operation::where('id', '=', $id)->first();
        $operation->delete();
        return response()->json([
            'operation' => $operation
        ], 200);
    }
}
