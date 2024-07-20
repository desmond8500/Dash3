<div class="col-md-6 mb-3">
    <label class="form-label">Nom </label>
    <input type="text" class="form-control" wire:model="status_form.name" placeholder="Nom">
    @error('status_form.name') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-3 mb-3">
    <label class="form-label">Niveau</label>
    <input type="number" class="form-control" wire:model="status_form.level" placeholder="Niveau">
    @error('status_form.level') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
<div class="col-md-3 mb-3">
    <label class="form-label">Couleur</label>
    <select class="form-control" wire:model="status_form.color">
        <option value="">Blanc</option>
        <option class="text-blue" value="blue">Blue</option>
        <option class="text-azure" value="azure">Azure</option>
        <option class="text-indigo" value="indigo">Indigo</option>
        <option class="text-purple" value="purple">Violet</option>
        <option class="text-pink" value="pink">Rose</option>
        <option class="text-red" value="red">Rouge</option>
        <option class="text-orange" value="orange">Orange</option>
        <option class="text-yellow" value="yellow">Jaune</option>
        <option class="text-lime" value="lime">Lime</option>
        <option class="text-green" value="green">Vert</option>
        <option class="text-teal" value="teal">Teal</option>
        <option class="text-cyan" value="cyan">Cyan</option>
        <option class="text-secondary" value="secondary">Gris</option>
    </select>
    @error('status_form.color') <span class='text-danger'>{{ $message }}</span> @enderror
</div>
