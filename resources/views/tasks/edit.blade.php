<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('tasks.edit_task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('tasks.update', $task) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="naziv_rada" class="block text-sm font-medium text-gray-700">{{ __('tasks.title_hr') }}</label>
                            <input type="text" name="naziv_rada" id="naziv_rada" value="{{ old('naziv_rada', $task->naziv_rada) }}" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('naziv_rada')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="naziv_rada_engleski" class="block text-sm font-medium text-gray-700">{{ __('tasks.title_en') }}</label>
                            <input type="text" name="naziv_rada_engleski" id="naziv_rada_engleski" value="{{ old('naziv_rada_engleski', $task->naziv_rada_engleski) }}" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('naziv_rada_engleski')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="zadatak_rada" class="block text-sm font-medium text-gray-700">{{ __('tasks.task_description') }}</label>
                            <textarea name="zadatak_rada" id="zadatak_rada" rows="6" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('zadatak_rada', $task->zadatak_rada) }}</textarea>
                            @error('zadatak_rada')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="tip_studija" class="block text-sm font-medium text-gray-700">{{ __('tasks.study_type') }}</label>
                            <select name="tip_studija" id="tip_studija" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">{{ __('tasks.select_study_type') }}</option>
                                <option value="stručni" {{ old('tip_studija', $task->tip_studija) === 'stručni' ? 'selected' : '' }}>{{ __('tasks.strucni') }}</option>
                                <option value="preddiplomski" {{ old('tip_studija', $task->tip_studija) === 'preddiplomski' ? 'selected' : '' }}>{{ __('tasks.preddiplomski') }}</option>
                                <option value="diplomski" {{ old('tip_studija', $task->tip_studija) === 'diplomski' ? 'selected' : '' }}>{{ __('tasks.diplomski') }}</option>
                            </select>
                            @error('tip_studija')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('tasks.index') }}" class="text-gray-600 hover:text-gray-900">{{ __('tasks.cancel') }}</a>
                            <button type="submit" style="background-color: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: bold;">
                                {{ __('tasks.update') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>