<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('user')->latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        // Provjera da li je korisnik nastavnik
        if (auth()->user()->role !== 'nastavnik') {
            abort(403, 'Samo nastavnici mogu dodavati radove.');
        }

        return view('tasks.create');
    }

    public function store(Request $request)
    {
        // Provjera da li je korisnik nastavnik
        if (auth()->user()->role !== 'nastavnik') {
            abort(403, 'Samo nastavnici mogu dodavati radove.');
        }

        $validated = $request->validate([
            'naziv_rada' => 'required|string|max:255',
            'naziv_rada_engleski' => 'required|string|max:255',
            'zadatak_rada' => 'required|string',
            'tip_studija' => 'required|in:stručni,preddiplomski,diplomski',
        ]);

        auth()->user()->tasks()->create($validated);

        return redirect()->route('tasks.index')->with('success', __('tasks.success_added'));
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Možete uređivati samo svoje radove.');
        }

        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Možete uređivati samo svoje radove.');
        }

        $validated = $request->validate([
            'naziv_rada' => 'required|string|max:255',
            'naziv_rada_engleski' => 'required|string|max:255',
            'zadatak_rada' => 'required|string',
            'tip_studija' => 'required|in:stručni,preddiplomski,diplomski',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', __('tasks.success_updated'));
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Možete brisati samo svoje radove.');
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', __('tasks.success_deleted'));
    }
}