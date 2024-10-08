<x-app-layout>
    <div>

        <a href="{{ route('bookings') }}" class="text-xs text-blue-500">&larr; Go Back</a>

        <h2 class="text-xl font-medium mt-3">Now choose a service form {{ $employee->name }}</h2>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-8 mt-6">

            @foreach($services as $service)
            <a href="{{ route('checkout', [$employee, $service]) }}" class="py-8 px-4 border border-slate-200 rounded-lg shadow-sm flex flex-col items-center justify-center text-center hover:bg-gray-50/75">
                <div
                    class="text-sm font-medium mt-3 text-slate-600 shadow-sm"
                >
                    {{ $service->title }}
                </div>

                <div
                    class="text-sm font-medium mt-3 text-slate-400 shadow-sm"
                >
                    {{ $service->duration }} minutes
                </div>

                <div
                    class="text-xl mt-3 text-slate-600 bg-slate-200 shadow-sm rounded-lg py-0.5 px-1.5"
                >
                    {{ $service->price }}
                </div>
            </a>
            @endforeach

        </div>
    </div>
</x-app-layout>
