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
        
        // Popola il form
        const form = document.getElementById('libraryActionForm');
        form.setAttribute('data-library-id', id);  // Aggiungiamo l'ID come data attribute
        
        document.getElementById('name').value = library.data.name;
        document.getElementById('description').value = library.data.description;
        document.getElementById('version').value = library.data.version;
        
        // Mostra il modale
        toggleAddForm();
        
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
            if (!row) {
                console.error('Row not found for library ID:', id);
                return;
            }

           
            // Aggiorna solo se trova gli elementi
            const nameCell = row.querySelector('.library-name');
            const versionCell = row.querySelector('.library-version');
            const statusCell = row.querySelector('.library-status');

            if (nameCell) nameCell.textContent = formData.get('name');
            if (versionCell) versionCell.textContent = formData.get('version');
            if (statusCell) statusCell.textContent = formData.get('status');
            
            // Chiudi il modale
            toggleAddForm();
            
            // Feedback all'utente
            alert('Libreria aggiornata con successo!');
        } else {
            throw new Error(result.error || 'Errore sconosciuto');
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

    const form = document.getElementById('libraryActionForm');
    if (form) {
        form.addEventListener('submit', async function(event) {
            event.preventDefault();
            event.stopPropagation();
            
            const formData = new FormData(this);
            const id = this.getAttribute('data-library-id'); // Prendiamo l'ID dal data attribute
            
            // Log per debug
            console.log('Library ID:', id);
            console.log('Form Data:', Object.fromEntries(formData));

            try {
                const response = await fetch(`/libraries/update/${id}`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                // Log per debug
                console.log('Response status:', response.status);
                const responseText = await response.text();
                console.log('Response text:', responseText);

                // Verifica che la risposta non sia vuota
                if (!responseText) {
                    throw new Error('Risposta vuota dal server');
                }

                // Prova a parsare la risposta JSON
                const result = JSON.parse(responseText);
                
                if (result.success) {
                    // Aggiorna i dati nella tabella
                    const row = document.querySelector(`tr[data-library-id="${id}"]`);
                    if (!row) {
                        console.error('Row not found for library ID:', id);
                        return;
                    }

                    // Aggiorna solo se trova gli elementi
                    const nameCell = row.querySelector('.library-name');
                    const versionCell = row.querySelector('.library-version');
                    const statusCell = row.querySelector('.library-status');

                    console.log('Row found:', row);
                    console.log('Name cell:', nameCell);
                    console.log('Version cell:', versionCell);
                    console.log('Status cell:', statusCell);
                    console.log('Form data:', {
                        name: formData.get('name'),
                        version: formData.get('version'),
                        status: formData.get('status')
                    });
                
                
                    if (nameCell) nameCell.textContent = formData.get('name');
                    if (versionCell) versionCell.textContent = formData.get('version');
                    if (statusCell) statusCell.textContent = formData.get('status');
                    
                    // Chiudi il modale
                    toggleAddForm();
                    
                    // Feedback all'utente
                    // alert('Libreria aggiornata con successo!');
                } else {
                    throw new Error(result.error || 'Errore sconosciuto');
                }
                
            } catch (error) {
                console.error('Errore completo:', error);
                alert('Errore durante l\'aggiornamento della libreria: ' + error.message);
            }
            
            return false;
        });
    }
});
