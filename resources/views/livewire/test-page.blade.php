<div class="row">
    {{-- <style>
        .tb_container{
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 10px;
        }
    </style>

    <a href="https://dribbble.com/shots/14989897/attachments/6710382?mode=media"> to design</a>


    <div class="row">
        <div class="col-md-4">
            <div class="tb_container">
                @foreach ($collection as $item)
                    @include('_card.button_card')
                @endforeach
            </div>
        </div>
        <div class="col-md-4">
            @include('_card.client_card1')

        </div>
        <div class="col-md-4">
            @include('_card.client_card')

        </div>
        <div class="col-md-4">
            @include('_form.task_detail')

        </div>
        <div class="col-md-4 mt-3">

            @component('components.tab.tab', ['tabs'=>$tabs, 'selected_tab'=>$selected_tab])
                <div class="tab-pane {{ $selected_tab == 0 ? 'active show' : '' }} " id="tabs-home-ex2">
                    <h4>Home tab</h4>
                    <div>Cursus turpis vestibulum, dui in pharetra vulputate id sed non turpis ultricies fringilla at sed
                        facilisis lacus pellentesque purus nibh</div>
                </div>
                <div class="tab-pane {{ $selected_tab == 1 ? 'active' : '' }}" id="tabs-profile-ex2">
                    <h4>Profile tab</h4>
                    <div>Fringilla egestas nunc quis tellus diam rhoncus ultricies tristique enim at diam, sem nunc amet,
                        pellentesque id egestas velit sed</div>
                </div>
                <div class="tab-pane {{ $selected_tab == 2 ? 'active' : '' }}" id="tabs-settings-ex2">
                    <h4>Settings tab</h4>
                    <div>Donec ac vitae diam amet vel leo egestas consequat rhoncus in luctus amet, facilisi sit mauris
                        accumsan nibh habitant senectus</div>
                </div>
            @endcomponent

        </div>
        <div class="col-md-4">
            <div class="row">
                <x-input type='images' name='Prénom' class='col-md-2' placeholder='hello'></x-input>
                <x-input type='text' name='Prénom' class='col-md-4' placeholder='hello'></x-input>
                <x-input type='text' name='Nom' class='col-md-6' ></x-input>
                <x-input type='text' name='Email' class='col-md-4' ></x-input>
                <x-input type='text' name='Fonction' class='col-md-6' ></x-input>
                <x-input type='select' name='genre' :options='$genre' class='col-md-6' ></x-input>
                <x-input type='password' name='Mot de passe' class='col-md-6' ></x-input>
                <x-input type='textarea' name='Description' class='col-md-12' ></x-input>

            </div>
        </div>
    </div>

    <button class="btn btn-primary" wire:click='store'>store</button> --}}
    @php
        $list = (object) array(
            (object) array('name'=> 'test', 'link'=>'test')
        );
    @endphp

    <div class="col-4 mt-3">
        <x-dropdown :list="$list"></x-dropdown>

    </div>
</div>
