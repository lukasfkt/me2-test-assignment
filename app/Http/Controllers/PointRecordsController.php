<?php

namespace App\Http\Controllers;

use App\Jobs\InsertPointRecordsJob;
use Exception;
use Illuminate\Http\Request;

class PointRecordsController extends Controller
{
    /**
     * [POST] - Create new point record
     *
     * @param Request request with time, latitude, longitude and selfie (optional)
     * 
     * @throws Response status code 400 with error message
     * @author Lucas Tanaka
     * @return Response status code 201
     */

    public function store()
    {
        try {
            # Request validation
            $this->validate(request(), [
                'time' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'selfie' => 'image|mimes:png,jpg,jpeg|max:2048'
            ]);
        } catch (\Exception $e) {
            # Abort with status code 400 with error message missing some information
            abort(400, $e->getMessage());
        }
        $selfie = request('selfie');
        $point = request()->only(['time', 'latitude', 'longitude']);
        if ($selfie) {
            $imageName = time() . '.'  . $selfie->extension();
            $selfie->move(public_path('selfies'), $imageName);
            $point['selfie'] = $imageName;
        }
        try {
            # Inserts the creation of a new point record in the queue
            InsertPointRecordsJob::dispatch($point);
            return response("Point record inserted in the queue", 201);
        } catch (Exception $e) {
            # Abort with status code 400 with error message
            abort(400, $e->getMessage());
        }
    }
}
