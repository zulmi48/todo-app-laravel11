<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use App\Models\todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = 5;
        if (request('search')) {
            $todos = Todo::where('task', 'like', '%' .request('search'). '%')->paginate($perPage)->withQueryString();
        }else {            
            $todos = Todo::orderBy('created_at', 'asc')->paginate($perPage);
        }
        return view('todo.app', compact('todos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task'=>'required|min:3',
        ]);

        Todo::create($validated);

        return redirect()->route('todo.index')->with('success', 'Berhasil menambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'task'=>'required|min:3',
            'is_done' => 'required'
        ]);

        Todo::findOrFail($id)->update($validated);

        return redirect()->route('todo.index')->with('success', 'Berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Todo::destroy($id);

        return redirect()->route('todo.index')->with('success', 'Berhasil dihapus');
    }
}
