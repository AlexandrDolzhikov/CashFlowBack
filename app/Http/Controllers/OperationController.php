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
        $operation = Operation::create($request->all());

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
        $operation = Operation::where('id', '=', $id)->first();
        $category  = \App\OperationType::where('id', '=', $operation->type_operation_id)->first();
        unset($operation->type_operation_id);
        
        $operation->category = $category;

        \Log::info($operation);

        return response()->json([
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
        $operation = Operation::where('id', '=', $id)->first();
        $operation->update($request->all());

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
        $operation = Operation::where('id', '=', $id)->first();
        $operation->delete();

        return response()->json([
            'operation' => $operation
        ], 200);
    }
}
