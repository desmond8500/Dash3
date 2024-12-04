<style>
    .avatar1{
        background-image:  url("https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8YXZhdGFyfGVufDB8fDB8fHww" )
        background-size: cover;
    }
</style>
<div class="avatar1 border" >

    <div>
        <img class="img-fluid"
        src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8YXZhdGFyfGVufDB8fDB8fHww">

        <div class="text-center" >
            <div class="fw-bold">{{  $user->firstname ?? 'Prénom' }} {{ $user->lastname ?? 'Nom' }}</div>
            <div>{{ $user->function ?? 'Fonction' }}</div>
        </div>
    </div>

</div>
