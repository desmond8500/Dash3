<div class="row g-2 mt-3">
    <div class="col-md-3">
        <div class="card mb-2">
            <div class="card-header">
                <div class="card-title">Modèle</div>
                <div class="card-actions">
                    <button wire:click="load_models" class="btn btn-primary btn-icon">
                        <i class="ti ti-reload"></i>
                    </button>
                    <button wire:click="load_models" class="btn btn-primary btn-icon">
                        <i class="ti ti-plus"></i>
                    </button>
                </div>
            </div>
            <div class="p-2">
                <select wire:model.live="selectedModel" class="form-select">
                    <option value="">-- Sélectionner un modèle --</option>

                    @foreach ($models as $model)
                    <option value="{{ $model }}">
                        {{ $model }}
                    </option>
                    @endforeach
                </select>


            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">Ajouter un modèle</div>
                <div class="card-actions">
                    <button class="btn btn-icon btn-primary" wire:click="addAttribute">
                        <i class="ti ti-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="">

                    <div class="mb-3">
                        <label class="form-label">Nom du modèle</label>

                        <input type="text" wire:model="modelName" class="form-control" placeholder="Ex: Client">

                        @error('modelName')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        @foreach ($modelAttributes as $index => $attribute)
                            <div class="input-group mb-1">
                                <input type="text" wire:model="modelAttributes.{{ $index }}.name" class="form-control">

                                <select wire:model="modelAttributes.{{ $index }}.type" class="form-select">
                                    <option value="string">String</option>
                                    <option value="text">Text</option>
                                    <option value="integer">Integer</option>
                                    <option value="decimal">Decimal</option>
                                    <option value="boolean">Boolean</option>
                                    <option value="date">Date</option>
                                    <option value="datetime">DateTime</option>
                                    <option value="foreignId">Foreign ID</option>
                                </select>

                                <button class="btn btn-icon btn-primary" wire:click="removeAttribute('{{ $index }}')">
                                    <i class="ti ti-minus"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Éléments à générer
                        </label>

                        <div class="form-check">
                            <input type="checkbox" wire:model="modelOptions.migration" class="form-check-input" id="migration">
                            <label class="form-check-label" for="migration">
                                Migration
                            </label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" wire:model="modelOptions.factory" class="form-check-input" id="factory">
                            <label class="form-check-label" for="factory">
                                Factory
                            </label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" wire:model="modelOptions.seeder" class="form-check-input" id="seeder">
                            <label class="form-check-label" for="seeder">
                                Seeder
                            </label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" wire:model="modelOptions.controller" class="form-check-input" id="controller">
                            <label class="form-check-label" for="controller">
                                Controller
                            </label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" wire:model="modelOptions.resource" class="form-check-input" id="resource">
                            <label class="form-check-label" for="resource">
                                API Resource
                            </label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" wire:model="modelOptions.policy" class="form-check-input" id="policy">
                            <label class="form-check-label" for="policy">
                                Policy
                            </label>
                        </div>

                    </div>

                </div>

            </div>
            <div class="card-footer">
                <button wire:click="createModel" wire:loading.attr="disabled" class="btn btn-primary">
                    <span wire:loading.remove>
                        Créer le modèle
                    </span>

                    <span wire:loading>
                        Création...
                    </span>
                </button>
            </div>
        </div>

    </div>

    <div class="col-md-9">
        <div class="row">
            <div class="col-md">
                <div class="card mb-2">
                    <div class="card-header">
                        <div class="card-title">Attributs</div>
                        <div class="card-actions">

                        </div>
                    </div>
                    <div class="card-body">
                        @if ($fillable)
                        <ul>
                            @foreach ($fillable as $attribute)
                            <li>{{ $attribute['name'] }}</li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md">
                <div class="card mb-2">
                    <div class="card-header">
                        <div class="card-title">Relations</div>
                        <div class="card-actions">

                        </div>
                    </div>
                    <div class="card-body">
                        @if ($relations)

                        <h4>Relations</h4>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Type</th>
                                    <th>Modèle lié</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($relations as $relation)
                                <tr>
                                    <td>{{ $relation['name'] }}</td>
                                    <td>{{ $relation['type'] }}</td>
                                    <td>{{ class_basename($relation['related']) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md">
                <div class="card mb-2">
                    <div class="card-header">
                        <div class="card-title">Methods</div>
                        <div class="card-actions">

                        </div>
                    </div>
                    <div class="card-body">
                        @if ($methods)

                        <h4>Methodes</h4>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Paramètres</th>
                                    {{-- <th>Modèle lié</th> --}}
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($methods as $method)
                                <tr>
                                    <td>{{ $method['name'] }}</td>
                                    <td>
                                        @foreach ($method['parameters'] as $item)
                                        <div>{{ $item['name']}}</div>
                                        @endforeach
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
