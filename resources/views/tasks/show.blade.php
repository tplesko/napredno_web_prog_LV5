<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('tasks.task_details') }}
            </h2>
            <a href="{{ route('tasks.index') }}" class="text-blue-600 hover:text-blue-900">
                ← {{ __('tasks.back_to_list') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $task->naziv_rada }}</h3>
                        <p class="text-lg text-gray-600 italic">{{ $task->naziv_rada_engleski }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('tasks.study_type') }}</p>
                            <p class="font-semibold">{{ __('tasks.' . $task->tip_studija) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('tasks.teacher') }}</p>
                            <p class="font-semibold">{{ $task->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('tasks.created_date') }}</p>
                            <p class="font-semibold">{{ $task->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('tasks.last_modified') }}</p>
                            <p class="font-semibold">{{ $task->updated_at->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">{{ __('tasks.task_description') }}</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="whitespace-pre-line">{{ $task->zadatak_rada }}</p>
                        </div>
                    </div>

                    @if(auth()->user()->id === $task->user_id)
                        <div class="flex gap-4">
                            <a href="{{ route('tasks.edit', $task) }}" style="background-color: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-weight: bold; display: inline-block;">
                                {{ __('tasks.edit') }}
                            </a>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background-color: #ef4444; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: bold;" onclick="return confirm('{{ __('tasks.confirm_delete') }}')">
                                    {{ __('tasks.delete') }}
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>