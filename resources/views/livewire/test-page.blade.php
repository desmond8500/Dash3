<div class="row">
    <div class="col-md-4">
        <div class="row">

            {{-- @include('_form.achat_form') --}}
        </div>

    </div>

    <div class="col-md-4">
        <div class="mt-2" wire:ignore>

            <select class="js-example-basic-multiple form-control" wire:model="select" name="states[]" multiple="multiple">
                <option value="AL">Alabama</option>
                <option value="WY">Wyoming</option>
            </select>
            {{ $select }}

            @script


            <script>
                $(document).ready(function() {
                    $('.js-example-basic-multiple').select2({
                        placeholder: "Select a state",
                        allowClear: true
                    });
                });
            </script>

            @endscript
        </div>

        <button wire:confirm="Are you sure?" wire:click="delete">Delete post</button>
    </div>

    <div class="col-md-4">
        <button class="btn btn-primary" wire:click="alert_modal()">Alert</button>
        @script
            <script>
                window.addEventListener('swal:modal', event => {
                    swal.fire({
                        title: "bug",
                        text: event.message,
                        icon: event.type,
                    });
                });
            </script>

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @endscript
    </div>




</div>
