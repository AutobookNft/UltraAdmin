console.log('library.js caricato correttamente')

window.editLibrary = editLibrary;
window.toggleAddForm = toggleAddForm;
window.deleteLibrary = deleteLibrary;
window.action = '';


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

function toggleAddForm($action) {
    const form = document.getElementById('libraryForm');
    const formFields = document.getElementById('libraryActionForm');

    if (form.classList.contains('hidden')) {
        form.classList.remove('hidden');
        if ($action === 'create') {
            console.log('Aggiungi Libreria');
            document.getElementById('formTitle').textContent = 'Aggiungi Libreria';
            window.action = 'create';
            
            // Clear all form fields
            formFields.reset();
        } else {
            console.log('Modifica Libreria');
            document.getElementById('formTitle').textContent = 'Modifica Libreria';
            window.action = 'update';
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
            console.log('Action:', window.action);

            try {
                let response; // Dichiara response fuori dal blocco if/else
        
                if (window.action === 'update') {
                    console.log('Modifica Libreria');
                    response = await fetch(`/libraries/update/${id}`, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });
                } else {
                    console.log('Aggiungi Libreria');
                    response = await fetch(`/libraries/store`, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });
                }

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
                    if (window.action === 'update') {
                        // Aggiorna i dati nella tabella esistente
                        const row = document.querySelector(`tr[data-library-id="${id}"]`);
                        if (!row) {
                            console.error('Row not found for library ID:', id);
                            return;
                        }
                
                        // Aggiorna solo se trova gli elementi
                        const nameCell = row.querySelector('.library-name');
                        const versionCell = row.querySelector('.library-version');
                        const statusCell = row.querySelector('.library-status');
                        const authorCell = row.querySelector('.library-author');
                        const tagsCell = row.querySelector('.library-tags');
                
                        if (nameCell) nameCell.textContent = formData.get('name');
                        if (versionCell) versionCell.textContent = formData.get('version');
                        if (statusCell) statusCell.textContent = formData.get('status');
                        if (authorCell) authorCell.textContent = formData.get('author');
                        if (tagsCell) tagsCell.textContent = formData.get('tags');
                    } else {
                        // Aggiungi nuova riga alla tabella
                        const tbody = document.querySelector('table tbody');
                        const newRow = document.createElement('tr');
                        newRow.setAttribute('data-library-id', result.data.id);
                        
                        newRow.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap library-name">
                                ${formData.get('name')}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap library-version">
                                ${formData.get('version')}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap library-status">
                                ${formData.get('status')}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap library-author">
                                ${formData.get('author') || '-'}
                            </td>
                            <td class="px-6 py-4 library-tags">
                                ${formData.get('tags') || ''}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                ${ViewHelpers.formatDate(result.data.updated_at)}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button onclick="editLibrary('${result.data.id}')" 
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 transition-colors duration-200 rounded-lg bg-blue-50 hover:bg-blue-100">
                                    <i class="mr-2 fas fa-edit"></i> Modifica
                                </button>
                                <button onclick="deleteLibrary('${result.data.id}')" 
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-600 transition-colors duration-200 rounded-lg bg-red-50 hover:bg-red-100">
                                    <i class="mr-2 fas fa-trash"></i> Elimina
                                </button>
                            </td>
                        `;
                        
                        tbody.insertBefore(newRow, tbody.firstChild);
                    }
                    
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
