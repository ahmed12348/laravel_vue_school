<?php

namespace App\Http\Controllers\api;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

use App\Http\Resources\GradeItemResource;
use App\Models\GradeItem;
use Validator;
class GradeItemController extends BaseController
{
    public function index()
    {
        $GradeItems = GradeItem::all();
        return $this->sendResponse(GradeItemResource::collection($GradeItems), 'GradeItems retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        return $request->all();
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'max_degree' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $GradeItem = GradeItem::create($input);

        return $this->sendResponse(new GradeItemResource($GradeItem), 'GradeItem created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $GradeItem = GradeItem::find($id);

        if (is_null($GradeItem)) {
            return $this->sendError('GradeItem not found.');
        }

        return $this->sendResponse(new GradeItemResource($GradeItem), 'GradeItem retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $GradeItem = GradeItem::find($id);
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'max_degree' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $GradeItem->name = $input['name'];
        $GradeItem->max_degree = $input['max_degree'];
        $GradeItem->save();
        return $this->sendResponse(new GradeItemResource($GradeItem), 'GradeItem updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $GradeItem = GradeItem::find($id);


        $GradeItem->delete();

        return $this->sendResponse([], 'GradeItem deleted successfully.');
    }

}
