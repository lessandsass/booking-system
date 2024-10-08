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
                    picker: null,
                    availableDates: {{ json_encode($availableDates) }},
                }"
                x-init="
                    this.picker = new easepick.create({
                        element: $refs.date,
                        readonly: true,
                        zIndex: 50,
                        date: '{{ $firstAvailableDate }}',
                        css: [
                            'https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.1/dist/index.css',
                            '/vendor/easepick/easepick.css',
                        ],
                        plugins: [
                            'LockPlugin'
                        ],
                        LockPlugin: {
                            minDate: new Date(),
                            filter (date, picked) {
                                return !Object.keys(availableDates).includes(date.format('YYYY-MM-DD'))
                            }
                        },
                        setup (picker) {
                            picker.on('view', (e) => {
                                const { view, date, target } = e.detail
                                const dateString = date ? date.format('YYYY-MM-DD') : null

                                if (view === 'CalendarDay' && availableDates[dateString]) {
                                    const span = target.querySelector('.day-slots') || document.createElement('span')

                                    span.className = 'day-slots'

                                    span.innerHTML = pluralize('slot', availableDates[dateString], true)

                                    target.append(span)
                                }
                            })
                        }
                    })
                "
            >
                <input
                    x-ref="date"
                    class="mt-6 text-sm bg-slate-100 border-0 rounded-lg px-6 py-4 w-full"
                    placeholder="Choose a date"
                >
            </div>

        </div>
    </div>
</x-app-layout>





