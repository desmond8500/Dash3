<div class="card">
    <div class="card-header">
        <div class="card-title">Planning de la semaine - {{ ucfirst($carbon->monthName) }} {{ $carbon->year }}</div>
        <div class="card-actions">
            <a href="{{ route('calendrier') }}" class="btn" wire:navigate>Calendrier</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    @for ($i = 0; $i < 7; $i++)
                        @php
                            $day = $carbon->copy()->startOfWeek()->addDays($i);
                        @endphp

                        <th class="text-center">
                            <div class="fw-semibold">
                                {{ ucfirst($day->dayName) }}
                            </div>

                            <small class="text-muted">
                                {{ $day->format('d/m') }}
                            </small>
                        </th>
                    @endfor
                </tr>
            </thead>

            <tbody>
                <tr>
                    @for ($i = 0; $i < 7; $i++)
                        @php
                            $day = $carbon->copy()->startOfWeek()->addDays($i);
                            $tasks = $planning->getTasks($day->format('Y-m-d'));
                        @endphp

                        <td class="planning-day">
                            @forelse ($tasks as $task)
                                <div class="card mb-1">
                                    <div class="card-status-start bg-blue"></div>
                                    <div class="card-body p-2">
                                        <div style="font-size: 10px" >
                                            <a href="{{ route('projet', ['projet_id'=> $task->projet->id]) }}">{{ $task->projet->name }}</a>
                                        </div>
                                        {{ $task->name }}
                                    </div>
                                </div>


                                {{-- <div class="task-card mb-2 p-2 rounded">
                                    <div class="fw-semibold">
                                        {{ $plan->name }}
                                    </div>
                                </div> --}}
                            @empty
                                <div class="text-center text-muted small py-3">
                                    Aucune tâche
                                </div>
                            @endforelse
                        </td>
                    @endfor
                </tr>
            </tbody>
        </table>
    </div>

    <style>
        .planning-day {
        min-width: 180px;
        min-height: 150px;
        vertical-align: top;
        background: #fafafa;
        }

        .task-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-left: 4px solid #3b82f6;
        box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
        }

        .task-card:hover {
        background: #f8fafc;
        }
    </style>

</div>
