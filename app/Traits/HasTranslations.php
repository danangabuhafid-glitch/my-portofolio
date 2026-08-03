<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait HasTranslations
{
    /**
     * Get the translated value for a given attribute.
     *
     * @param string $attribute
     * @return mixed
     */
    public function getTranslation(string $attribute)
    {
        $locale = App::getLocale(); // 'id' or 'en'
        $column = $attribute . '_' . $locale;
        
        // Fallback to English if the specific language column is empty
        $value = $this->{$column};
        
        if (empty($value) && $locale !== 'en') {
            $value = $this->{$attribute . '_en'};
        }
        
        return $value;
    }
}
