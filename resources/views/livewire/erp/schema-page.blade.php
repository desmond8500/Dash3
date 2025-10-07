<div>
    @component('components.layouts.page-header', ['title'=>'Schema', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            <button class="btn btn-primary">{{ $schema->type }}</button>
        </div>
    @endcomponent

    <div class="row g-2">
        @if ($schema->type == 'rack')
            <div class="col-md-4">
                <img src="https://i.pinimg.com/1200x/2f/df/ba/2fdfbaa674f1247d82ee93683bf67347.jpg" alt="">
            </div>
            <div class="col-md-4">
                @livewire('rackextended', ['schema_id' => $schema->id])

            </div>
        @else
            <div class="col-md-8">
                @livewire('diagramextended', ['schema_id' => $schema->id])

            </div>
        @endif

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Articles</div>
                    <div class="card-actions">
                        <div class="input-icon">
                            <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher un article">
                            <span class="input-icon-addon">
                                <i class="ti ti-search"></i>
                            </span>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    @foreach ($items as $item)
                        <div class="card p-2 mb-1" wire:click="add_item('{{ $item->id }}')" style="cursor: pointer;">
                            {{ $item->name }}
                        </div>
                    @endforeach
                    <div>
                        {{ $items->links() }}
                    </div>
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </div>
</div>
