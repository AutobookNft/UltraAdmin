<!-- Barra di ricerca e pulsante nuovo -->
<div class="flex items-center justify-between p-4 border-b border-gray-100">
    <input type="text" 
            class="w-64 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" 
            placeholder="Cerca librerie...">
    <button class="flex items-center px-4 py-2 space-x-2 text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700"
            onclick="toggleAddForm('create')">
        <i class="fas fa-plus"></i>
        <span>Nuova Libreria</span>
    </button>
</div>