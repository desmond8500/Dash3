<div>
    @component('components.layouts.page-header', ['title'=>'Journal', 'breadcrumbs'=>$breadcrumbs])
    <div class="btn-list">
        {{-- @livewire('form.task-add', ['projet_id' => $projet_id])
        @livewire('form.journal-add', ['projet_id' => $projet_id]) --}}
    </div>
    @endcomponent

    <div class="row g-2">
        <div class="col-md-4">

            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ $journal->title }}</div>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-icon" disabled>
                            <i class="ti ti-edit"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    {!! nl2br($journal->description) !!}
                </div>
            </div>

        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Rapports</div>
                    <div class="card-actions">

                    </div>
                </div>
                <div class="card-body">

                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </div>
</div>
