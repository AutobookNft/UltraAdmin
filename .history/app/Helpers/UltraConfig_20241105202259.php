<?php

namespace App\Helpers;

use Fabio\UltraAdmin\Facades\UConfigFacade;

class UltraConfig
{
    /**
     * Ottiene un valore di configurazione utilizzando UConfigFacade.
     *
     * @param string $key La chiave di configurazione dot-separated
     * @return mixed Il valore della configurazione richiesta
     * @throws \Exception
     */
    public static function get(string $key)
    {
        return UConfigFacade::get($key);
    }
}
