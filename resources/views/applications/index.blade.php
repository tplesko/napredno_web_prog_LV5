<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('applications.available_tasks') }}
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
                        <p class="text-gray-500 text-center py-8">{{ __('applications.no_available_tasks') }}</p>
                    @else
                        <div class="grid gap-6">
                            @foreach($tasks as $task)
                                <div class="border rounded-lg p-6 hover:shadow-lg transition">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex-1">
                                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $task->naziv_rada }}</h3>
                                            <p class="text-gray-600 italic mb-2">{{ $task->naziv_rada_engleski }}</p>
                                            <div class="flex gap-4 text-sm text-gray-500">
                                                <span>{{ __('tasks.teacher') }}: <strong>{{ $task->user->name }}</strong></span>
                                                <span>{{ __('tasks.study_type') }}: <strong>{{ __('tasks.' . $task->tip_studija) }}</strong></span>
                                            </div>
                                        </div>
                                        
                                        @php
                                            $userApplication = $task->applications->first();
                                        @endphp
                                        
                                        @if($userApplication)
                                            <span class="px-3 py-1 text-sm rounded-full 
                                                @if($userApplication->status === 'accepted') bg-green-200 text-green-800
                                                @elseif($userApplication->status === 'rejected') bg-red-200 text-red-800
                                                @else bg-yellow-200 text-yellow-800
                                                @endif">
                                                {{ __('applications.' . $userApplication->status) }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="bg-gray-50 p-4 rounded mb-4">
                                        <p class="text-sm text-gray-700 whitespace-pre-line">{{ Str::limit($task->zadatak_rada, 200) }}</p>
                                    </div>

                                    <div class="flex gap-3">
                                        <a href="{{ route('tasks.show', $task) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ __('tasks.task_details') }} →
                                        </a>
                                        
                                        @if(!$userApplication)
                                            <form action="{{ route('applications.store', $task) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                    style="background-color: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: bold;">
                                                    {{ __('applications.apply') }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function openApplyModal(taskId) {
            document.getElementById('applyForm').action = `/tasks/${taskId}/apply`;
            document.getElementById('applyModal').classList.remove('hidden');
        }

        function closeApplyModal() {
            document.getElementById('applyModal').classList.add('hidden');
            document.getElementById('message').value = '';
        }

        // Zatvori modal klikom izvan njega
        document.getElementById('applyModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeApplyModal();
            }
        });
    </script>
</x-app-layout>