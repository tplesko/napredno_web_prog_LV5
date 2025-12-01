<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Završni i Diplomski Radovi
            </h2>
            @if(auth()->user()->role === 'nastavnik')
                <a href="{{ route('tasks.create') }}" 
                    style="background-color: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-weight: bold; display: inline-block;">
                    Dodaj Novi Rad
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($tasks->isEmpty())
                        <p class="text-gray-500 text-center py-8">Nema dodanih radova.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Naziv Rada</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tip Studija</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nastavnik</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Datum</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Akcije</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($tasks as $task)
                                        <tr>
                                            <td class="px-6 py-4">
                                                <a href="{{ route('tasks.show', $task) }}" class="text-blue-600 hover:text-blue-900">
                                                    {{ $task->naziv_rada }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 text-xs rounded-full bg-blue-200 text-blue-800">
                                                    {{ ucfirst($task->tip_studija) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $task->user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $task->created_at->format('d.m.Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @if(auth()->user()->role === 'nastavnik' && auth()->user()->id === $task->user_id)
                                                    <a href="{{ route('tasks.edit', $task) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">{{ __('tasks.edit') }}</a>
                                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('{{ __('tasks.confirm_delete') }}')">{{ __('tasks.delete') }}</button>
                                                    </form>
                                                @elseif(auth()->user()->role === 'student')
                                                    @php
                                                        $userApplication = $task->applications->where('user_id', auth()->id())->first();
                                                    @endphp
                                                    
                                                    @if($userApplication)
                                                        <span class="px-2 py-1 text-xs rounded-full
                                                            @if($userApplication->status === 'accepted') bg-green-200 text-green-800
                                                            @elseif($userApplication->status === 'rejected') bg-red-200 text-red-800
                                                            @else bg-yellow-200 text-yellow-800
                                                            @endif">
                                                            {{ __('applications.' . $userApplication->status) }}
                                                        </span>
                                                    @else
                                                        <span class="text-gray-400">-</span>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>