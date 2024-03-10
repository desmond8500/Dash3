<div>
    <style>
        .tb_container{
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 10px;
        }
    </style>

    <div class="tb_container">
        @foreach ($collection as $item)
            @include('_card.button_card')
        @endforeach

        <a href="https://dribbble.com/shots/14989897/attachments/6710382?mode=media"> to design</a>

    </div>

    <div class="row">
        <div class="col-md-4">
            @include('_card.client_card1')

        </div>
        <div class="col-md-4">
            @include('_card.client_card')

        </div>
        <div class="col-md-4">
            @include('_form.task_detail')

        </div>
    </div>

</div>
