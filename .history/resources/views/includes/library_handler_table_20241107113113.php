

<!-- Versione Desktop -->
<div class="hidden overflow-x-auto md:block">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <!-- ... header della tabella invariato ... -->
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
                        <?php echo htmlspecialchars($library['status']); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap library-created">
                        <?php echo htmlspecialchars($library['created_at']); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <!-- ... bottoni invariati ... -->
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
