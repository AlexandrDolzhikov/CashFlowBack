<?php

namespace App\Http\Controllers;

use App\OperationType;
use Illuminate\Http\Request;

class OperationTypeController extends Controller
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
        $operationType = OperationType::create($request->all());

        return response()->json([
            "operationType" => $operationType
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
     * @param  \App\OperationType  $operationType
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $operation_id = $request->get('operationId');
        $user_id      = $request->get('userId');
        $category = OperationType::where('id', '=', $operation_id)->where('author_id', '=', $user_id)->first();

        return response()->json([
            'category' => $category
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OperationType  $operationType
     * @return \Illuminate\Http\Response
     */
    public function edit(OperationType $operationType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OperationType  $operationType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OperationType $operationType)
    {
        $category = OperationType::where('id', '=', $request->get('id'));
        $category->update($request->all());

        return response()->json([
            'category' => $category
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OperationType  $operationType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, OperationType $operationType)
    {
        $operation_id = $request->get('operationId');
        $user_id      = $request->get('userId');
        $operation = OperationType::where('id', '=', $operation_id)->where('author_id', '=', $user_id)->first();
        $operation->delete();

        return response()->json([
            'operation' => $operation
        ], 200);
    }
}
