<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Collaborator;
use Illuminate\Support\Facades\Redis;

class CollaboratorsController extends Controller
{
    /**
     * [GET] - List all collaborators
     *
     * @author Lucas Tanaka
     * @return Collaborator[]
     */

    public function list()
    {
        # Using Redis to store collaborator list
        $collaborartosList = json_decode(Redis::get('collaborartosList'));
        if ($collaborartosList) {
            # If exist key in Redis
            return $collaborartosList;
        }
        $collaborartosList = Collaborator::all();

        # Set collaboratorList key on Redis - Expiration 2h
        Redis::set('collaborartosList', json_encode($collaborartosList), 'EX', 7200);

        return $collaborartosList;
    }

    /**
     * [POST] - Create new collaborator
     *
     * @param Request request with name, registration, cpf and schedule_id
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
                'name' => 'required',
                'registration' => 'required',
                'cpf' => 'required|cpf',
                'schedule_id' => 'required'
            ]);
        } catch (\Exception $e) {
            # Abort with status code 400 with error message missing some information
            abort(400, $e->getMessage());
        }

        # Create new collaborator
        try {
            $collaborator = Collaborator::create(request(['name', 'registration', 'cpf', 'schedule_id']));
        } catch (\Exception $e) {
            abort(400, "Failed to register a collaborator");
        }

        # Clear redis key collaborartosList
        Redis::set('collaborartosList', null);

        return $collaborator;
    }

    /**
     * [PUT] - Edit existing collaborator
     *
     * @param Request request with collaborator_id, name, registration, cpf and schedule_id
     * 
     * @throws Exception If missing information
     * @throws Response status code 400 "User not founded"
     * @author Lucas Tanaka
     * @return Response status code 200 "User updated"
     */

    public function edit()
    {
        try {
            # Request validation
            $this->validate(request(), [
                'collaborator_id' => 'required',
                'name' => 'required',
                'registration' => 'required',
                'cpf' => 'required|cpf',
                'schedule_id' => 'required'
            ]);
        } catch (\Exception $e) {
            # Abort with status code 400 with error message missing some information
            abort(400, $e->getMessage());
        }

        # Update collaborator
        if (!Collaborator::where('id', request('collaborator_id'))->update(request(['name', 'registration', 'cpf', 'schedule_id']))) {
            # Abort with status code 400 with messagem "User not founded"
            abort(400, "User not founded");
        }

        # Clear redis key collaborartosList
        Redis::set('collaborartosList', null);

        return response("User updated", 200);
    }

    /**
     * [DELETE] - Delete existing collaborator
     *
     * @param Request request with collaborator_id
     * 
     * @throws Exception If missing information
     * @throws Response status code 400 "User not founded"
     * @author Lucas Tanaka
     * @return Response status code 200 "User updated"
     */

    public function delete()
    {
        try {
            # Request validation
            $this->validate(request(), [
                'collaborator_id' => 'required',
            ]);
        } catch (\Exception $e) {
            # Abort with status code 400 with error message missing some information
            abort(400, $e->getMessage());
        }

        # Delete collaborator
        if (!Collaborator::where('id', request('collaborator_id'))->delete()) {
            # Abort with status code 400 with messagem "User not founded"
            abort(400, "User not founded");
        }

        # Clear redis key collaborartosList
        Redis::set('collaborartosList', null);

        return response("User deleted", 200);
    }

    /**
     * [GET] - Delete existing collaborator
     *
     * @param Request request with optional parameters name, registration, cpf and schedule_id
     * 
     * @throws Response status code 400 "Missing informations"
     * @author Lucas Tanaka
     * @return Collaborator[]
     */

    public function search()
    {
        # Request variables
        $name = request('name');
        $registration = request('registration');
        $cpf = request('cpf');
        $schedule_id = request('schedule_id');

        # Composed query - Add where according to received parameters
        $query = Collaborator::query();
        $query->when($name, function ($q, $name) {
            return $q->where('name', 'LIKE', "%$name%");
        });
        $query->when($registration, function ($q, $registration) {
            return $q->where('registration', 'LIKE', "%$registration%");
        });
        $query->when($cpf, function ($q, $cpf) {
            return $q->where('cpf', 'LIKE', "%$cpf%");
        });
        $query->when($schedule_id, function ($q, $schedule_id) {
            return $q->where('schedule_id', 'LIKE', "%$schedule_id%");
        });

        # Get list of collaborators
        $collaborators = $query->get();
        return $collaborators;
    }
}
