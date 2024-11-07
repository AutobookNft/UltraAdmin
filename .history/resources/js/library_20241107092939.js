
console.log('library.js caricato correttamente')

window.editLibrary = editLibrary;

async function editLibrary(id) {
    try {
        // Chiamata API per ottenere i dati della libreria
        
        console.log('editLibrary', id)

        const url = `/libraries/edit/${id}`;
        console.log('Calling URL:', url);
        
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                // Se usi CSRF protection
                // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
            },
            credentials: 'same-origin' // Include i cookies nella richiesta
        });

        if (!response.ok) throw new Error('Errore nel caricamento dei dati');
        
        const library = await response.json();

        console.log('editLibrary', library.data)
        
        // Popola il form con i dati ricevuti
        document.getElementById('name').value = library.data.name;
        document.getElementById('description').value = library.data.description;
        document.getElementById('version').value = library.data.data.version;
        
        // Aggiorna titolo e action del form
        document.getElementById('formTitle').textContent = 'Modifica Libreria';
        document.getElementById('libraryActionForm').action = `/libraries/update/${id}`;
        
        // Mostra il modale
        document.getElementById('libraryForm').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
    } catch (error) {
        console.error('Errore:', error);
        alert('Errore nel caricamento dei dati della libreria');
    }
}

function toggleAddForm() {
    const form = document.getElementById('libraryForm');
    if (form.classList.contains('hidden')) {
        form.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    } else {
        form.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

function deleteLibrary(id) {
    if (confirm('Sei sicuro di voler eliminare questa libreria?')) {
        // Implementare la logica di eliminazione
    }
}

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    // Chiudi il modale se si clicca fuori
    document.getElementById('libraryForm').addEventListener('click', function(e) {
        if (e.target === this) {
            toggleAddForm();
        }
    });
});
