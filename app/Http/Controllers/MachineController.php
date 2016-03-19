<?php

namespace App\Http\Controllers;

use App\Machine;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function index($group = 'mslab')
    {
        return response(Machine::where('group', $group)->orderBy('ordering', 'asc')->get())->header('Access-Control-Allow-Origin', '*');
    }

    public function update(Request $request)
    {
        $token = $request->token;

        $scope = \App\Scope::where('token', $token)->first();

        if (!$scope) {
            return response()->json([
                'status' => 'unauthorized',
            ], 403);
        }

        $machine = Machine::find($scope->machine_id);

        foreach (['load1', 'load5', 'load15', 'memory_using'] as $key) {
            if ($request->has($key)) {
                $machine[$key] = $request->input($key);
            }
        }

        $machine->save();

        return ['status' => 'success'];
    }
}
