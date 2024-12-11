<?php


namespace App\Services;


class GeneralService
{
    /**
     * @param array $data
     * @return array
     */
    public static function sanitize_data(array $data): array
    {
        foreach ($data as $key => $value) {
            $data[$key] = htmlspecialchars($value);
        }
        return $data;
    }

}
