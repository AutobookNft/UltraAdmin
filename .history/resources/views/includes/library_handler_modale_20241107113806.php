
<!-- Form Modale -->
<div id="libraryForm" class="fixed inset-0 hidden w-full h-full overflow-y-auto bg-gray-600 bg-opacity-50" style="z-index: 50;">
    <div class="relative w-full max-w-md p-5 mx-auto top-20">
        <div class="bg-white shadow-2xl rounded-xl">
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <h2 id="formTitle" class="text-2xl font-bold text-gray-800"></h2>
                <button onclick="toggleAddForm('create')" class="text-gray-400 transition-colors hover:text-gray-600">
                    <i class="text-xl fas fa-times"></i>
                </button>
            </div>

            <form id="libraryActionForm" method="POST" onsubmit="updateLibrary(event)updateLibrary(event) class="p-6 space-y-6">
                <div class="space-y-4">
                    <div class="flex flex-col space-y-2">
                        <label for="name" class="text-sm font-medium text-gray-700">Nome Libreria</label>
                        <input type="text" 
                                id="name" 
                                name="name" 
                                class="border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                    </div>
                    
                    <div class="flex flex-col space-y-2">
                        <label for="description" class="text-sm font-medium text-gray-700">Descrizione</label>
                        <textarea id="description" 
                                    name="description" 
                                    class="h-24 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    rows="3"></textarea>
                    </div>

                    <div class="flex flex-col space-y-2">
                        <label for="version" class="text-sm font-medium text-gray-700">Versione</label>
                        <input type="text" 
                                id="version" 
                                name="version" 
                                class="border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex justify-end pt-6 space-x-3 border-t border-gray-100">
                    <button type="submit" 
                            class="px-4 py-2 font-medium text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="mr-2 fas fa-save"></i> Salva
                    </button>
                    <button type="button" 
                            onclick="toggleAddForm('close')" 
                            class="px-4 py-2 font-medium text-gray-700 transition-colors bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <i class="mr-2 fas fa-times"></i> Annulla
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>