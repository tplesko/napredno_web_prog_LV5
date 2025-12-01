<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('applications.applications_on_tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($tasks->isEmpty())
                        <p class="text-gray-500 text-center py-8">{{ __('applications.no_applications') }}</p>
                    @else
                        <div class="space-y-8">
                            @foreach($tasks as $task)
                                <div class="border rounded-lg p-6">
                                    <div class="mb-4">
                                        <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $task->naziv_rada }}</h3>
                                        <p class="text-gray-600 text-sm">{{ __('tasks.study_type') }}: {{ __('tasks.' . $task->tip_studija) }}</p>
                                    </div>

                                    @if($task->applications->isEmpty())
                                        <p class="text-gray-500 italic">{{ __('applications.no_applications_yet') }}</p>
                                    @else
                                        <div class="space-y-4">
                                            @foreach($task->applications as $application)
                                                <div class="bg-gray-50 rounded-lg p-4 border-l-4 
                                                    @if($application->status === 'accepted') border-green-500
                                                    @elseif($application->status === 'rejected') border-red-500
                                                    @else border-yellow-500
                                                    @endif">
                                                    <div class="flex justify-between items-start mb-3">
                                                        <div>
                                                            <p class="font-semibold text-gray-800">{{ $application->user->name }}</p>
                                                            <p class="text-sm text-gray-500">{{ $application->user->email }}</p>
                                                            <p class="text-xs text-gray-400 mt-1">
                                                                {{ __('applications.date_applied') }}: {{ $application->created_at->format('d.m.Y H:i') }}
                                                            </p>
                                                        </div>
                                                        <span class="px-3 py-1 text-sm rounded-full
                                                            @if($application->status === 'accepted') bg-green-200 text-green-800
                                                            @elseif($application->status === 'rejected') bg-red-200 text-red-800
                                                            @else bg-yellow-200 text-yellow-800
                                                            @endif">
                                                            {{ __('applications.' . $application->status) }}
                                                        </span>
                                                    </div>

                                                    @if($application->message)
                                                        <div class="mb-3">
                                                            <p class="text-sm font-medium text-gray-700 mb-1">{{ __('applications.student_message') }}:</p>
                                                            <p class="text-sm text-gray-600 bg-white p-3 rounded">{{ $application->message }}</p>
                                                        </div>
                                                    @endif

                                                    @if($application->status === 'pending')
                                                        <div class="flex gap-3 mt-3">
                                                            <form action="{{ route('applications.accept', $application) }}" method="POST" class="inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" 
                                                                    onclick="return confirm('{{ __('applications.confirm_accept') }}')"
                                                                    style="background-color: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: bold;">
                                                                    {{ __('applications.accept') }}
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('applications.reject', $application) }}" method="POST" class="inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" 
                                                                    onclick="return confirm('{{ __('applications.confirm_reject') }}')"
                                                                    style="background-color: #ef4444; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: bold;">
                                                                    {{ __('applications.reject') }}
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>