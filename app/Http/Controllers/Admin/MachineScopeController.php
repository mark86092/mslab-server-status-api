<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class MachineScopeController extends Controller
{
    public function store($machine_id)
    {
        $scope = new \App\Scope();
        $scope->token = str_random(20);

        \App\Machine::findOrFail($machine_id)->scopes()->save($scope);

        return redirect()->action('Admin\MachineController@edit', [$machine_id]);
    }

    public function destroy($machine_id, $scope_id)
    {
        $scope = \App\Scope::find($scope_id);
        $scope->delete();

        return redirect()->action('Admin\MachineController@edit', [$machine_id]);
    }
}
