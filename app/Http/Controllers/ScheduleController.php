<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Support\Facades\Redis;

class ScheduleController extends Controller
{
    /**
     * [GET] - List all Schedules
     *
     * @author Lucas Tanaka
     * @return Schedule[]
     */

    public function list()
    {

        # Using Redis to store collaborator list
        $scheduleList = json_decode(Redis::get('scheduleList'));
        if ($scheduleList) {
            # If exist key in Redis
            return $scheduleList;
        }
        $scheduleList = Schedule::all();
        # Set collaboratorList key on Redis -  Expiration 2h
        Redis::set('scheduleList', json_encode($scheduleList), 'EX', 7200);
        return $scheduleList;
    }

    /**
     * [POST] - Create new Schedule
     *
     * @param Request request with name
     * 
     * @throws Response status code 400 with error message
     * @author Lucas Tanaka
     * @return Collaborator
     */

    public function store()
    {
        try {
            # Request validation
            $this->validate(request(), [
                'name' => 'required'
            ]);
        } catch (\Exception $e) {
            # Abort with status code 400 with error message missing some information
            abort(400, $e->getMessage());
        }

        # Create new Schedule
        try {
            $schedule = Schedule::create(request(['name']));
        } catch (\Exception $e) {
            abort(400, "Failed to create a schedule");
        }

        # Clear redis key scheduleList
        Redis::set('scheduleList', null);

        return $schedule;
    }
}
