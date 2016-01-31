<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function index()
    {
        $machines = \App\Machine::with('scopes')->get();

        return view('admin.machines.index', ['machines' => $machines]);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $machine = new \App\Machine();
        $machine->group = $request->group;
        $machine->hostname = $request->hostname;
        $machine->cpus = $request->cpus;
        $machine->memory = $request->memory;

        $machine->save();

        return redirect()->action('Admin\MachineController@index');
    }

    public function edit($id)
    {
        $machine = \App\Machine::findOrFail($id);

        return view('admin.machines.edit', ['machine' => $machine]);
    }

    public function update(Request $request, $id)
    {
        $machine = \App\Machine::findOrFail($id);
        $machine->group = $request->group;
        $machine->hostname = $request->hostname;
        $machine->cpus = $request->cpus;
        $machine->memory = $request->memory;

        $machine->save();

        return redirect()->action('Admin\MachineController@index');
    }

    public function destroy($id)
    {
        $machine = \App\Machine::findOrFail($id);
        $machine->delete();

        return redirect()->action('Admin\MachineController@index');
    }
}
