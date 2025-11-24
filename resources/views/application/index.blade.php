<x-app-layout> 
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            Player Membership Applications
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-8">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-slate-800">
                    All Submitted Applications
                </h3>
                <p class="text-xs text-slate-500">
                    Shoot For The Stars · Youth Basketball Membership
                </p>
            </div>

            <table class="table-auto w-full text-sm">
                <thead class="bg-slate-50 text-slate-700">
                    <tr>
                        <th class="p-2.5 border border-slate-100 text-left w-12">#</th>
                        <th class="p-2.5 border border-slate-100 text-left">Player Name</th>
                        <th class="p-2.5 border border-slate-100 text-left">Age Category</th>
                        <th class="p-2.5 border border-slate-100 text-left">Status</th>
                        <th class="p-2.5 border border-slate-100 text-left">Submitted</th>
                        <th class="p-2.5 border border-slate-100 text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="text-slate-700">
                    @forelse($applications as $app)
                        <tr class="hover:bg-slate-50">
                            <td class="border border-slate-100 p-2.5 text-xs text-slate-500">
                                {{ $loop->iteration }}
                            </td>
                            {{-- company_name is now used as player name --}}
                            <td class="border border-slate-100 p-2.5">
                                {{ $app->company_name }}
                            </td>
                            {{-- sector is now age category (U8, U10, etc.) --}}
                            <td class="border border-slate-100 p-2.5">
                                {{ $app->sector }}
                            </td>
                            <td class="border border-slate-100 p-2.5 capitalize">
                                {{ $app->status }}
                            </td>
                            <td class="border border-slate-100 p-2.5 text-xs text-slate-500">
                                {{ $app->submitted_at?->format('d M Y') }}
                            </td>
                            <td class="border border-slate-100 p-2.5">
                                <a href="{{ route('admin.applications.show', $app) }}"
                                   class="text-indigo-600 hover:text-indigo-800 underline text-xs font-medium">
                                    View details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="border-t border-slate-100 p-4 text-center text-sm text-slate-500">
                                No applications submitted yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
