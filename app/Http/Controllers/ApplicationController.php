<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Task;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    // Student vidi dostupne radove
    public function index()
    {
        if (auth()->user()->role !== 'student') {
            abort(403, 'Samo studenti mogu pregledavati dostupne radove.');
        }

        // Radovi koji nemaju prihvaćenu prijavu
        $tasks = Task::with(['user', 'applications' => function($query) {
            $query->where('user_id', auth()->id());
        }])
        ->whereDoesntHave('applications', function($query) {
            $query->where('status', 'accepted');
        })
        ->latest()
        ->get();

        return view('applications.index', compact('tasks'));
    }

    // Student se prijavljuje na rad
    public function store(Request $request, Task $task)
    {
        if (auth()->user()->role !== 'student') {
            abort(403, 'Samo studenti se mogu prijavljivati na radove.');
        }

        // Provjeri da li je rad već zauzet
        if ($task->acceptedApplication) {
            return redirect()->back()->with('error', __('applications.already_taken'));
        }

        // Provjeri da li se student već prijavio
        $existingApplication = Application::where('task_id', $task->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingApplication) {
            return redirect()->back()->with('error', __('applications.already_applied'));
        }

        Application::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'message' => null,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', __('applications.success_applied'));
    }

    // Nastavnik vidi prijave na svoje radove
    public function myApplications()
    {
        if (auth()->user()->role !== 'nastavnik') {
            abort(403, 'Samo nastavnici mogu pregledavati prijave.');
        }

        $tasks = Task::where('user_id', auth()->id())
            ->with(['applications' => function($query) {
                $query->with('user')->latest();
            }])
            ->latest()
            ->get();

        return view('applications.my-applications', compact('tasks'));
    }

    // Nastavnik prihvaća studenta
    public function accept(Application $application)
    {
        if (auth()->user()->id !== $application->task->user_id) {
            abort(403, 'Možete prihvatiti samo prijave na svoje radove.');
        }

        // Provjeri da li je rad već zauzet
        if ($application->task->acceptedApplication) {
            return redirect()->back()->with('error', __('applications.already_accepted'));
        }

        $application->update(['status' => 'accepted']);

        // Odbij sve ostale prijave na taj rad
        Application::where('task_id', $application->task_id)
            ->where('id', '!=', $application->id)
            ->where('status', 'pending')
            ->update(['status' => 'rejected']);

        return redirect()->back()->with('success', __('applications.success_accepted'));
    }

    // Nastavnik odbija studenta
    public function reject(Application $application)
    {
        if (auth()->user()->id !== $application->task->user_id) {
            abort(403, 'Možete odbiti samo prijave na svoje radove.');
        }

        $application->update(['status' => 'rejected']);

        return redirect()->back()->with('success', __('applications.success_rejected'));
    }
}