<x-app-layout>
    <div class="space-y-12">

        <div>
            <h2 class="text-xl font-medium mt-3">Here's what you're booking</h2>
            <div class="flex mt-6 space-x-3 bg-slate-100 rounded-lg p-4">
                <img src="{{ $employee->profile_photo_url }}" class="rounded-lg size-14 bg-slate-100">
                <div class="w-full">
                    <div class="flex justify-between">
                        <div class="font-semibold">
                            {{ $service->title }} ({{ $service->duration }} minutes)
                        </div>
                        <div class="text-sm">
                            {{ $service->price }}
                        </div>
                    </div>
                    <div class="text-sm">
                        {{ $employee->name }}
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-xl font-medium mt-3">1. When for?</h2>
            <div
                x-data="{
                    picker: null
                }"
                x-init="
                    picker='abcdf'
                    console.log(picker)
                "
            >
                Calender
            </div>
        </div>

    </div>
</x-app-layout>





