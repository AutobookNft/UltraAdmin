
console.log('library.js caricato correttamente')

const libraryForm = document.getElementById('libraryForm');
window.libraryForm = libraryForm;


async function editLibrary(id) {
    try {
        // Chiamata API per ottenere i dati della libreria
        
        console.log('editLibrary', id)
        
        const response = await fetch(`/libraries/edit/${id}`);
        if (!response.ok) throw new Error('Errore nel caricamento dei dati');
        
        const library = await response.json();

        console.log('editLibrary', library)
        
        // Popola il form con i dati ricevuti
        document.getElementById('name').value = library.name;
        document.getElementById('description').value = library.description;
        document.getElementById('version').value = library.version;
        
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
