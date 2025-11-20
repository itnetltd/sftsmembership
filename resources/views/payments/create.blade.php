<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- flashes / errors --}}
        @if(session('ok'))
            <div class="mb-6 rounded-lg bg-green-50 text-green-700 px-4 py-3">
                {{ session('ok') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 rounded-lg bg-red-50 text-red-700 px-4 py-3">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-6 rounded-lg bg-red-50 text-red-700 px-4 py-3">
                <div class="font-semibold">Please fix the following:</div>
                <ul class="list-disc ml-6 mt-2">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl border border-slate-200 shadow-soft">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h1 class="text-xl font-semibold">Make a Payment</h1>
                <a href="{{ route('payments.index') }}"
                   class="text-sm text-ram-blue underline">Billing History</a>
            </div>

            <form method="POST" action="{{ route('payments.store') }}" class="px-6 py-6 space-y-5">
                @csrf

                {{-- amount --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Amount (RWF)</label>
                    <input
                        type="number"
                        name="amount"
                        min="100"
                        step="100"
                        value="{{ old('amount', 1000) }}"
                        required
                        class="w-full rounded-md border-slate-300 focus:border-ram-blue focus:ring-ram-blue">
                </div>

                {{-- method --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Payment Method</label>

                    <select id="methodSelect" name="method"
                            class="w-full rounded-md border-slate-300 focus:border-ram-blue focus:ring-ram-blue"
                            required>
                        <option value="momo" {{ old('method','momo')==='momo' ? 'selected' : '' }}>
                            Mobile Money (MTN Rwanda)
                        </option>

                        @php
                            $flwOk = config('services.flutterwave.secret_key') && config('services.flutterwave.base_url');
                        @endphp
                        <option value="card" {{ old('method')==='card' ? 'selected' : '' }}>
                            Bank Card (Visa/Mastercard)
                        </option>
                    </select>

                    @unless($flwOk)
                        <p class="mt-2 text-xs text-slate-500">
                            Card payments require Flutterwave keys. Currently not configured.
                        </p>
                    @endunless
                </div>

                {{-- MTN number (MSISDN) – visible only for MoMo --}}
                <div id="msisdnBlock" class="{{ old('method','momo')==='momo' ? '' : 'hidden' }}">
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        MTN Number (MSISDN)
                    </label>
                    <input
                        type="text"
                        name="msisdn"
                        value="{{ old('msisdn', '250796680916') }}"
                        placeholder="2507XXXXXXXX"
                        inputmode="numeric"
                        pattern="^2507\d{8}$"
                        class="w-full rounded-md border-slate-300 focus:border-ram-blue focus:ring-ram-blue">
                    <p class="text-xs text-slate-500 mt-1">Format: <strong>2507XXXXXXXX</strong> (no + or spaces).</p>
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg bg-ram-blue text-white hover:opacity-90">
                        Pay Now
                    </button>
                    <a href="{{ route('payments.index') }}"
                       class="ml-3 inline-flex items-center px-4 py-2.5 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <div class="mt-6 text-sm text-slate-500">
            After submitting, you’ll receive a MoMo prompt on your phone (or card checkout for cards).
            Return to <a class="underline text-ram-blue" href="{{ route('payments.index') }}">Billing</a>
            to refresh pending payments.
        </div>
    </div>

    {{-- tiny toggle script, no extra libs needed --}}
    <script>
        (function () {
            const select = document.getElementById('methodSelect');
            const msisdn = document.getElementById('msisdnBlock');
            const toggle = () => {
                if (select.value === 'momo') msisdn.classList.remove('hidden');
                else msisdn.classList.add('hidden');
            };
            select.addEventListener('change', toggle);
            toggle();
        })();
    </script>
</x-app-layout>
