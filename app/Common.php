<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

if (!function_exists('cloudinary_thumb')) {
    /**
     * Genera una URL optimizada de Cloudinary para thumbnails de productos.
     *
     * @param string|null $url URL cruda de Cloudinary (res.cloudinary.com)
     * @param int $width Ancho deseado en píxeles (default 400)
     * @return string URL optimizada o placeholder local
     */
    function cloudinary_thumb(?string $url, int $width = 400): string
    {
        if (empty($url)) {
            return base_url('assets/images/banners/no_image.webp');
        }

        if (strpos($url, 'res.cloudinary.com') === false) {
            return $url;
        }

        $transformations = "f_auto,q_auto,w_{$width},c_limit";

        return preg_replace(
            '/(\/upload\/)(v\d+\/)?/',
            '$1' . $transformations . '/$2',
            $url,
            1
        );
    }
}
