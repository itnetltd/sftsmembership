<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Membership Applications</h2>
    </x-slot>

    <div class="py-6 px-8">
        <table class="table-auto w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">#</th>
                    <th class="p-2 border">Company</th>
                    <th class="p-2 border">Sector</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Submitted</th>
                    <th class="p-2 border">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $app)
                    <tr>
                        <td class="border p-2">{{ $loop->iteration }}</td>
                        <td class="border p-2">{{ $app->company_name }}</td>
                        <td class="border p-2">{{ $app->sector }}</td>
                        <td class="border p-2 capitalize">{{ $app->status }}</td>
                        <td class="border p-2">{{ $app->submitted_at?->format('d M Y') }}</td>
                        <td class="border p-2">
                            <a href="{{ route('admin.applications.show', $app) }}" class="text-blue-600 underline">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
