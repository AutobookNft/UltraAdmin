<?php
    use App\Helpers\ViewHelpers;
?> 

<!-- Versione Desktop -->
<div class="hidden overflow-x-auto md:block w-11/12 mx-auto px-4">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Nome</th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Versione</th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Stato</th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Autore</th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Tags</th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Ultimo Agg.</th>
                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Azioni</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($libraries as $library): ?>
                <tr data-library-id="<?php echo htmlspecialchars($library['id']); ?>">
                    <td class="px-6 py-4 whitespace-nowrap library-name">
                        <?php echo htmlspecialchars($library['name']); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap library-version">
                        <?php echo htmlspecialchars($library['version']); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap library-status">
                        <span class="px-2 py-1 text-sm rounded-full <?php echo ViewHelpers::getStatusClass($library['status']); ?>">
                            <?php echo htmlspecialchars($library['status']); ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap library-author">
                        <?php echo htmlspecialchars($library['author'] ?? '-'); ?>
                    </td>
                    <td class="px-6 py-4 library-tags">
                        <?php 
                        $tags = explode(',', $library['tags'] ?? '');
                        foreach ($tags as $tag): 
                            if (trim($tag)): ?>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">
                                    <?php echo htmlspecialchars(trim($tag)); ?>
                                </span>
                            <?php endif;
                        endforeach; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php echo ViewHelpers::formatDate($library['updated_at']); ?>
                    </td>
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
