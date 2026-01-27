<div>
    @component('components.layouts.page-header', ['title'=> 'Test page'])
        <div class="btn-list">
            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
        </div>
    @endcomponent

    <a href="{{ route('pdf_v1',['title' => 'Document V1.0'])}}" target="_blank" class="btn btn-primary" >
        PDF
    </a>

    <main>
        main
        <div class="card card-body">

            <form class="row g-2">
                <div class="col">
                    <livewire:async-select class="las-border"
                        style="border: 1px solid red"
                        name="test" wire:model="test" :options="[
                                ['value' => '1', 'label' => 'Option 1'],
                                ['value' => '2', 'label' => 'Option 2'],
                                ['value' => '3', 'label' => 'Option 3'],
                                ]" placeholder="Select an option..." />

                </div>
                <div class="col">
                    <select class="form-select" name="" id="">
                        <option value="">1</option>
                        <option value="">2</option>
                        <option value="">3</option>
                    </select>

                </div>


            </form>
        </div>



    </main>


</div>
