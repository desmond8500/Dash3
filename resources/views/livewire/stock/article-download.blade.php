<div>
    @component('components.layouts.page-header', ['title'=> "Téléchargement d'articles", 'breadcrumbs'=> $breadcrumbs])

    @endcomponent

    <div class="row g-2">
        <div class="col-md-8">
            <div class="row g-2">
                <div class="col-md-12">
                    <div class="col-md-12 mb-3">
                        <input type="text" class="form-control" wire:model="article_search" placeholder="Rechercher" wire:keydown.enter="get_articles()">
                        @error('article_search') <span class='text-danger'>{{ $message }}</span> @enderror
                    </div>
                </div>

                @foreach ($articles['data'] as $article)
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
            </div>
        </div>
        <div class="col-md-4">

        </div>
    </div>

</div>
