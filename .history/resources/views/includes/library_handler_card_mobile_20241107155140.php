<?php
    use App\Helpers\ViewHelpers;
?> 

<!-- Versione Mobile (Cards) -->
<div class="p-4 space-y-6 md:hidden">
    <?php foreach ($libraries as $library): ?>
        <div class="overflow-hidden transition-all duration-300 bg-white border border-gray-100 shadow-lg rounded-xl hover:border-blue-100">
            <div class="p-4 border-b border-gray-100 bg-gray-50">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-gray-800">
                        <?php echo htmlspecialchars($library['name']); ?>
                    </h3>
                    <span class="px-3 py-1 text-sm font-medium <?php echo ViewHelpers::getStatusClass($library['status']); ?> rounded-full shadow-sm">
                        <?php echo htmlspecialchars($library['status']); ?>
                    </span>
                </div>
                <p class="mt-2 text-sm text-gray-600">
                    Autore: <?php echo htmlspecialchars($library['author'] ?? 'Sconosciuto'); ?>
                </p>
            </div>

            <div class="p-5 space-y-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                        <span class="text-sm font-medium text-gray-600">Versione:</span>
                        <span class="px-3 py-1 text-sm text-gray-800 bg-white rounded-md shadow-sm">
                            <?php echo htmlspecialchars($library['version'] ?? '1.0.0'); ?>
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                        <span class="text-sm font-medium text-gray-600">Data Creazione:</span>
                        <span class="px-3 py-1 text-sm text-gray-800 bg-white rounded-md shadow-sm">
                            <?php echo ViewHelpers::formatDate($library['created_at']); ?>
                        </span>
                    </div>
                </div>

                <div class="flex justify-end pt-4 space-x-3 border-t border-gray-100">
                    <button onclick="editLibrary('<?php echo htmlspecialchars($library['id']); ?>')" 
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 transition-colors duration-200 rounded-lg bg-blue-50 hover:bg-blue-100">
                        <i class="mr-2 fas fa-edit"></i> Modifica
                    </button>
                    <button onclick="deleteLibrary('<?php echo htmlspecialchars($library['id']); ?>')" 
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-600 transition-colors duration-200 rounded-lg bg-red-50 hover:bg-red-100">
                        <i class="mr-2 fas fa-trash"></i> Elimina
                    </button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

   