<div class="table-responsive-sm">
    <table class="table table-striped" id="projetProjets-table">
        <thead>
            <tr>
                <th>Client Id</th>
        <th>Name</th>
        <th>Description</th>
        <th>Categorie</th>
        <th>Statut</th>
        <th>Start</th>
        <th>End</th>
        <th>Contact Id</th>
        <th>Responsable Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($projetProjets as $projetProjet)
            <tr>
                <td>{{ $projetProjet->client_id }}</td>
            <td>{{ $projetProjet->name }}</td>
            <td>{{ $projetProjet->description }}</td>
            <td>{{ $projetProjet->categorie }}</td>
            <td>{{ $projetProjet->statut }}</td>
            <td>{{ $projetProjet->start }}</td>
            <td>{{ $projetProjet->end }}</td>
            <td>{{ $projetProjet->contact_id }}</td>
            <td>{{ $projetProjet->responsable_id }}</td>
                <td>
                    {!! Form::open(['route' => ['projetProjets.destroy', $projetProjet->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('projetProjets.show', [$projetProjet->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('projetProjets.edit', [$projetProjet->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>