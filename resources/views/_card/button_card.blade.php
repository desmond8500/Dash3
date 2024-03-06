<style>
    .tb_back{
        display: block;
        width: 100px;
        height: 100px;
        border-radius: 5px;
        text-align: center;
    }
    .tb_icon{
        position: relative;
        top: 10px;
        font-size: 20px;
    }
    .tb-name{
        position: relative;
        top: 50px;
    }
</style>

<div class="round border-primary bg-blue tb_back">
    <i class="ti {{ $icon ?? 'ti-user' }} text-white tb_icon"></i>
    <div class="text-white fw-bold text-center tb-name">{{ $name ?? 'Finances' }}</div>
</div>
