
        <!-- Navbar -->
        <nav class="mb-6 bg-gray-800 rounded-lg shadow-lg">
            <div class="flex items-center justify-between px-4 py-3">
                <a href="/" class="text-xl font-bold text-white">UltraAdmin</a>
                <ul class="flex space-x-6">
                    <li><a href="/libraries" class="text-white transition-colors hover:text-blue-300">Librerie</a></li>
                    <li><a href="/settings" class="text-white transition-colors hover:text-blue-300">Impostazioni</a></li>
                </ul>
            </div>
        </nav>

        <!-- Card principale -->
        <div class="bg-white shadow-lg rounded-xl">
            <!-- Barra di ricerca e pulsante nuovo -->
            <div class="flex items-center justify-between p-4 border-b border-gray-100">
                <input type="text" 
                       class="w-64 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                       placeholder="Cerca librerie...">
                <button class="flex items-center px-4 py-2 space-x-2 text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700"
                        onclick="toggleAddForm()">
                    <i class="fas fa-plus"></i>
                    <span>Nuova Libreria</span>
                </button>
            </div>

            <!-- Versione Desktop -->
            <div class="hidden overflow-x-auto md:block">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Nome</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Versione</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Stato</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Data Creazione</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Azioni</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Contenuto tabella -->
                        <?php foreach ($libraries as $library): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($library['name']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($library['version']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($library['status']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($library['created_at']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button onclick="editLibrary('<?php echo htmlspecialchars($library['id']); ?>')" 
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 transition-colors duration-200 rounded-lg bg-blue-50 hover:bg-blue-100">
                                        <i class="mr-2 fas fa-edit"></i> Modifica
                                    </button>
                                    <button onclick="deleteLibrary('<?php echo htmlspecialchars($library['id']); ?>')" 
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-600 transition-colors duration-200 rounded-lg bg-red-50 hover:bg-red-100">
                                        <i class="mr-2 fas fa-trash"></i> Elimina
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Versione Mobile (Cards)
            <div class="p-4 space-y-6 md:hidden">
                <?php foreach ($libraries as $library): ?>
                    <div class="overflow-hidden transition-all duration-300 bg-white border border-gray-100 shadow-lg rounded-xl hover:border-blue-100">
                        <div class="p-4 border-b border-gray-100 bg-gray-50">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl font-semibold text-gray-800">
                                    <?php echo htmlspecialchars($library['name']); ?>
                                </h3>
                                <span class="px-3 py-1 text-sm font-medium text-green-700 bg-green-100 rounded-full shadow-sm">
                                    Attiva
                                </span>
                            </div>
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
                                        <?php echo htmlspecialchars($library['created_at']); ?>
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
            </div> -->

            <?php
                include 'includes/library_handler_card_mobile.php'; 
            ?>

        </div>
    </div>

    <!-- Form Modale -->
    <?php
        include 'includes/library_handler_modale.php';
    ?>  

    <script>
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

        // Chiudi il modale se si clicca fuori
        document.getElementById('libraryForm').addEventListener('click', function(e) {
            if (e.target === this) {
                toggleAddForm();
            }
        });
    </script>
</body>
</html>