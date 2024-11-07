console.log('library.js caricato correttamente')

window.editLibrary = editLibrary;
window.toggleAddForm = toggleAddForm;
window.deleteLibrary = deleteLibrary;


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
        document.getElementById('version').value = library.data.version;
        
        // Aggiorna titolo e action del form
        document.getElementById('formTitle').textContent = 'Modifica Libreria';
        console.log('Modifica Libreria');
        // document.getElementById('libraryActionForm').action = `/libraries/update/${id}`;
        
        // Mostra il modale
        document.getElementById('libraryForm').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
    } catch (error) {
        console.error('Errore:', error);
        alert('Errore nel caricamento dei dati della libreria');
    }
}

async function updateLibrary(event) {
    event.preventDefault();
    event.stopPropagation();
    
    const form = document.getElementById('libraryActionForm');
    const formData = new FormData(form);
    const id = form.action.split('/').pop();

    try {
        const response = await fetch(`/libraries/update/${id}`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        });

        if (!response.ok) throw new Error('Errore nell\'aggiornamento');
        
        const result = await response.json();
        
        if (result.success) {
            // Aggiorna i dati nella tabella
            const row = document.querySelector(`tr[data-library-id="${id}"]`);
            if (row) {
                row.querySelector('.library-name').textContent = formData.get('name');
                row.querySelector('.library-description').textContent = formData.get('description');
                row.querySelector('.library-version').textContent = formData.get('version');
            }
            
            // Chiudi il modale
            toggleAddForm();
            
            // Feedback all'utente
            alert('Libreria aggiornata con successo!');
            
            return false;
        }
        
    } catch (error) {
        console.error('Errore:', error);
        alert('Errore durante l\'aggiornamento della libreria');
    }
    
    return false;
}

function toggleAddForm($action) {
    const form = document.getElementById('libraryForm');
    if (form.classList.contains('hidden')) {
        form.classList.remove('hidden');
        if ($action === 'create') {
            console.log('Aggiungi Libreria');
            document.getElementById('formTitle').textContent = 'Aggiungi Libreria';
        } else {
            console.log('Modifica Libreria');
            document.getElementById('formTitle').textContent = 'Modifica Libreria';
        }
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
