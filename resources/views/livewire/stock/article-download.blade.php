<div>
    @component('components.layouts.page-header', ['title'=> "Téléchargement d'articles", 'breadcrumbs'=> $breadcrumbs])
        <div class="btn-group">
            {{-- <label for="">Server</label> --}}
            <div class="input-group">
                <input type="text" class="form-control mb-2" wire:model="server_url" placeholder="Server">
                <button class="btn btn" wire:click="edit_server(server_url)">Modifier</button>
            </div>
            @error('server_url') <span class='text-danger'>{{ $message }}</span> @enderror
        </div>
    @endcomponent

    <div class="row g-2">
        <div class="col-md-8">
            <div class="row g-2">
                <div class="col-md-12">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" wire:model="article_search" placeholder="Rechercher">
                            <button class="btn btn-outline-primary" wire:click="get_articles(1)">
                                <i class="ti ti-search"></i>
                            </button>
                        </div>
                        @error('article_search') <span class='text-danger'>{{ $message }}</span> @enderror {{ $article_search }}
                    </div>
                </div>

                @foreach ($articles['data'] ?? [] as $article)
                    <div class="col-md-6">
                        <div class="card p-1">
                            <div class="row">
                                <div class="col-auto">
                                    <img src="{{ $article['image'] }}" alt="A" class="avatar avatar-xl rounded-2 p-1" style="object-fit: contain;">
                                </div>
                                <div class="col">
                                    <div class="card-title">{{ $article['designation'] }}</div>
                                </div>
                                <div class="col-auto">
                                  <button class="btn btn-outline-primary btn-icon" wire:click="store('{{ $article['id'] }}')">
                                    <i class="ti ti-download"></i>
                                  </button>
                              </div>
                            </div>
                        </div>

                    </div>
                @endforeach
                @isset ($articles['data'])
                    <div class="col-md-12 text-center">

                        <button wire:click="previousPage" class="btn" @if($articles['meta']['current_page'] <= 1) disabled @endif>Précédent</button>
                        @if ($articles['meta']['current_page'] > 1)
                            <button class="btn">{{ $articles['meta']['current_page'] - 1 }}</button>
                        @endif
                        <button class="btn btn-primary">{{ $articles['meta']['current_page'] }}</button>
                        <button class="btn ">{{ $articles['meta']['current_page'] + 1 }}</button>
                        <button wire:click="nextPage" class="btn" @if($articles['meta']['current_page'] >= $articles['meta']['last_page']) disabled @endif>Suivant</button>
                        <button class="btn" wire:click="get_articles({{ $articles['meta']['last_page'] }})">{{ $articles['meta']['last_page'] }}</button>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-4">

        </div>
    </div>

</div>
