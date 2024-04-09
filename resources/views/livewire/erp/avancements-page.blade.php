<div>
    @component('components.layouts.page-header', ['title'=>'Avancements', 'breadcrumbs'=>$breadcrumbs])
    <div class="btn-list">
        <a href="{{ route('avancements_pdf',['avancement_id'=>1]) }}" target="_blank" class="btn btn-primary" >PDF</a>
    </div>
    @endcomponent

    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Durée</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Avancement</th>
                    <th>Commentaires</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

    </div>
</div>
