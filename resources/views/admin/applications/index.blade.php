<x-app-layout>
    <div class="max-w-6xl mx-auto py-6">
        <h1 class="text-2xl font-semibold mb-4">Membership Applications</h1>

        @if(session('ok'))
            <div class="bg-green-50 text-green-700 p-3 rounded mb-4">{{ session('ok') }}</div>
        @endif

        @if($apps->isEmpty())
            <p>No applications yet.</p>
        @else
            <div class="overflow-x-auto bg-white shadow rounded">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left p-3">#</th>
                            <th class="text-left p-3">Company</th>
                            <th class="text-left p-3">Applicant</th>
                            <th class="text-left p-3">Sector</th>
                            <th class="text-left p-3">Location</th>
                            <th class="text-left p-3">Status</th>
                            <th class="text-left p-3">Submitted</th>
                            <th class="text-left p-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($apps as $app)
                            @php
                                $badge = match($app->status){
                                    'approved' => 'bg-green-600',
                                    'rejected' => 'bg-red-600',
                                    default => 'bg-yellow-600'
                                };
                            @endphp
                            <tr class="border-t">
                                <td class="p-3">{{ $app->id }}</td>
                                <td class="p-3 font-medium">{{ $app->company_name }}</td>
                                <td class="p-3">
                                    {{ optional($app->user)->name ?? '—' }}<br>
                                    <span class="text-xs text-gray-500">{{ optional($app->user)->email }}</span>
                                </td>
                                <td class="p-3">{{ $app->sector ?? '—' }}</td>
                                <td class="p-3">{{ $app->location ?? '—' }}</td>
                                <td class="p-3">
                                    <span class="inline-block text-white text-xs px-2 py-1 rounded {{ $badge }}">
                                        {{ ucfirst($app->status) }}
                                    </span>
                                </td>
                                <td class="p-3">{{ optional($app->submitted_at)->format('d M Y H:i') }}</td>
                                <td class="p-3">
                                    <a href="{{ route('admin.apps.show', $app) }}" class="text-blue-600 underline">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $apps->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
