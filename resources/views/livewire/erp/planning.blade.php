<div class="card">
    <div class="card-header">
        <div class="card-title">Planning de la semaine - {{ ucfirst($carbon->monthName) }} {{ $carbon->year }}</div>
        <div class="card-actions">
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                {{-- <td class="text-center">{{ ucfirst($carbon->dayName) }} {{ $carbon->startOfWeek()->format('d-m') }}</td> --}}
                <td class="text-center">{{ ucfirst($carbon->startOfWeek()->dayName) }} {{ $carbon->startOfWeek()->format('d-m') }}</td>
                <td class="text-center">{{ ucfirst($carbon->startOfWeek()->addDays(1)->dayName) }} {{ $carbon->startOfWeek()->addDays(1)->format('d-m') }}</td>
                <td class="text-center">{{ ucfirst($carbon->startOfWeek()->addDays(2)->dayName) }} {{ $carbon->startOfWeek()->addDays(2)->format('d-m') }}</td>
                <td class="text-center">{{ ucfirst($carbon->startOfWeek()->addDays(3)->dayName) }} {{ $carbon->startOfWeek()->addDays(3)->format('d-m') }}</td>
                <td class="text-center">{{ ucfirst($carbon->startOfWeek()->addDays(4)->dayName) }} {{ $carbon->startOfWeek()->addDays(4)->format('d-m') }}</td>
                <td class="text-center">{{ ucfirst($carbon->startOfWeek()->addDays(5)->dayName) }} {{ $carbon->startOfWeek()->addDays(5)->format('d-m') }}</td>
                <td class="text-center">{{ ucfirst($carbon->startOfWeek()->addDays(6)->dayName) }} {{ $carbon->startOfWeek()->addDays(6)->format('d-m') }}</td>
            </tr>



        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>
