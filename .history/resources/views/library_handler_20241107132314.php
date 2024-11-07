<?php

use App\Helpers\ViewHelpers;
?>  

<!DOCTYPE html>
<html lang="it">
<head>
    <title>Gestione Librerie</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo App\Helpers\ViteHelper::assets(); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    
    <!-- Container principale centrato -->
    <div class="container max-w-4xl px-4 py-6 mx-auto">
        
        <!-- Navbar -->
        <?php include 'includes/library_handler_navbar.php'; ?>

        <!-- Card principale -->
        <div class="bg-white shadow-lg rounded-xl">
            
            <!-- Barra di ricerca e pulsante nuovo -->
            <?php include 'includes/library_handler_search_bar.php'; ?>

            <!-- Versione Desktop -->
            <?php include 'includes/library_handler_table.php'; ?>
            
            <!-- Versione Mobile (Cards) -->
            <?php include 'includes/library_handler_card_mobile.php'; ?>
                
        </div>

    </div>

    <!-- Form Modale -->
    <?php include 'includes/library_handler_modale.php'; ?>  
   
</body>
</html>