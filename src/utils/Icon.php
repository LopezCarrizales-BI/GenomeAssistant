<?php
class Icon
{
    public static function get($name, $classes = '')
    {
        $path = ROOT_PATH . '/public/assets/icons/' . $name . '.svg';

        if (file_exists($path)) {
            $svgContent = file_get_contents($path);

            if ($classes) {
                $svgContent = str_replace('<svg', '<svg class="' . $classes . '"', $svgContent);
            }

            return $svgContent;
        }

        return '';
    }
}
