{{-- <div class="{{ $card_class ?? 'col-md-6' }}"> --}}
    <div class="card p-2">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                @if ($contact->photo)
                    <img src="{{ asset($contact->photo) }}" alt="A" class="avatar avatar-md">
                @else
                    <img src="{{ asset("img/icons/user1.png") }}" style="height: 64px; width: 64px" alt="A" class="">
                @endif
            </div>
            <div class="col">
                <div class="">{{ $contact->firstname }} <b>{{ strtoupper($contact->lastname) }}</b></div>
                @if ($contact->fonction)
                    <div class="text-primary d-flex align-items-center my-1" data-bs-toggle="tooltip" title="Fonction"> <i class="ti ti-briefcase-2"></i> {{ $contact->fonction }}</div>
                @endif
                @if ($contact->societe)
                    <div class="text-purple d-flex align-items-center my-1" data-bs-toggle="tooltip" title="Societe"><i class="ti ti-building"></i> {{ $contact->societe }}</div>
                @endif
                {{-- <div class="d-flex justify-content-between align-items-center mt-1"> --}}
                    @if ($contact->phone)
                    <div class="d-flex align-items-center" data-bs-toggle="tooltip" title="Téléphone">
                        @php
                            // $phone = new Propaganistas\LaravelPhone\PhoneNumber($contact->phone, 'SN');
                        @endphp
                        {{-- <i class="ti ti-phone"></i> <div class="ms-1">  {{ $phone->formatForCountry('SN') }}</div> --}}
                    </div>
                    @endif
                    @if ($contact->email)
                        <div class="d-flex align-items-center" data-bs-toggle="tooltip" title="Email">
                            <i class="ti ti-mail"></i>
                            <div class="ms-1"> {{ $contact->email }}</div>
                        </div>
                    @endif
                {{-- </div> --}}
            </div>
            <div class="col-auto">
                <div class="dropdown open">
                    <button class="btn btn-action" type="button" id="triggerId" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="ti ti-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="triggerId">
                        <a class="dropdown-item" wire:click="edit('{{ $contact->id }}')"> <i class="ti ti-edit"></i> Editer</a>
                        <a class="dropdown-item text-danger" wire:click="delete('{{ $contact->id }}')"> <i class="ti ti-trash"></i> Supprimer</a>
                    </div>
                </div>
            </div>
            <div class="col-md-12">

            </div>
        </div>
    </div>
{{-- </div> --}}
