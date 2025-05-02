<div class="" wire:ignore:self>
    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/fabric@latest/dist/index.min.js"></script>
    @endpush
    <canvas id="canvas" width="1000" height="600" style="border:1px solid #ccc;"></canvas>
    <button id="save">Sauvegarder</button>

    @push('script')
    <script src="/node_modules/fabric/dist/fabric.min.js"></script>
    @endpush
    <script>
        const canvas = new fabric.Canvas('canvas');

                    // Exemple : Ajouter un rectangle
                    const rect = new fabric.Rect({
                        left: 200,
                        top: 100,
                        fill: 'red',
                        width: 60,
                        height: 70
                    });
                    const rect1 = new fabric.Rect({
                        left: 100,
                        top: 100,
                        fill: 'blue',
                        width: 60,
                        height: 70
                    });
                    const rect2 = new fabric.Rect({
                        left: 300,
                        top: 100,
                        fill: 'green',
                        width: 60,
                        height: 70
                    });
                    canvas.add(rect);
                    canvas.add(rect1);
                    canvas.add(rect2);

                    // Sauvegarder les données
                    document.getElementById('save').addEventListener('click', () => {
                        const json = JSON.stringify(canvas.toJSON());
                        fetch('/save-plan', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: json
                        }).then(response => response.json())
                          .then(data => alert('Plan sauvegardé avec succès !'));
                    });
    </script>

</div>
