<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

use App\Http\Resources\LevelResource;
use App\Models\Level;
use Validator;

class LevelController extends BaseController
{
    public function index()
    {
        $levels = Level::all();

        return $this->sendResponse(LevelResource::collection($levels), 'levels retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'number' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $level = Level::create($input);

        return $this->sendResponse(new LevelResource($level), 'level created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $level = Level::find($id);

        if (is_null($level)) {
            return $this->sendError('level not found.');
        }

        return $this->sendResponse(new LevelResource($level), 'level retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, level $level)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'number' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $level->name = $input['name'];
        $level->desc = $input['desc'];
        $level->number = $input['number'];

        $level->save();

        return $this->sendResponse(new LevelResource($level), 'level updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(level $level)
    {
        $level->delete();

        return $this->sendResponse([], 'level deleted successfully.');
    }

}
