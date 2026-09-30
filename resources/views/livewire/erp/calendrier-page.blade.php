<div>
    @component('components.layouts.page-header', ['title'=> 'Calendrier'])

    @endcomponent

    <div class="row row-deck g-2 mb-3">
        @for ($i = 0; $i < 7; $i++)
            @php
                $day=$carbon->copy()->startOfWeek()->addDays($i);
                $tasks = $planning->getTasks($day->format('Y-m-d'));
            @endphp

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header p-2">
                        <div class="row g-2 align-items-center">
                            <div class="col-auto border border-primary text-primary text-center p-1 px-3 rounded">
                                <div>{{ $day->format('d') }}</div>
                                <div>{{ $day->format('M') }}</div>
                            </div>
                            <div class="col fs-2" >
                                {{ ucfirst($day->dayName) }}
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-2">
                        @forelse ($tasks as $task)
                            <div class="card mb-1">
                                <div class="card-status-start bg-blue"></div>
                                <div class="card-body p-2">
                                    <div style="font-size: 10px">
                                        <a href="{{ route('projet', ['projet_id'=> $task->projet->id]) }}">{{
                                            $task->projet->name }}</a>
                                    </div>
                                    {{ $task->name }}
                                </div>
                            </div>

                            @empty
                            <div class="text-center text-muted small py-3">
                                Aucune tâche
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endfor
    </div>


</div>
