<?php
class Router
{
    public static function urlView($dir = '', $page = '', $options = [])
    {
        $url = 'index.php';

        if ($dir == '' || $page == '') {
            return $url;
        }

        $url .= '?dir=' . $dir . '&page=' . $page;

        foreach ($options as $key => $value) {
            $url .= '&' . $key . '=' . $value;
        }

        return $url;
    }

    public static function urlProcess($dir, $page, $options = [])
    {
        $url = 'process.php';
        $url .= '?dir=' . $dir . '&page=' . $page;

        foreach ($options as $key => $value) {
            $url .= '&' . $key . '=' . $value;
        }

        return $url;
    }

    public static function controlFile($dir, $file, $extension = 'php')
    {
        $path = $dir . $file . '.' . $extension;
        if (!file_exists($path)) {
            // Dans le message d'erreur, on indique pas $dir
            // Pour ne pas donner un "flag"
            die('Erreur Routing [001] : ' . $file . ' inexistant');
        }
    }

    public static function controlMethod($class, $method)
    {
        if (!is_callable([$class, $method])) {
            die('Erreur Routing [002] : ' . $method . ' inexistante');
        }
    }

    public static function get($name, $control = '')
    {
        if (!isset($_GET[$name])) {
            die('Erreur Routing [003] : ' . $name . ' inexistant');
        }

        if ($control != '' && !$control($_GET[$name])) {
            die('Erreur Routing [003] : ' . $name . ' au mauvais format');
        }

        return $_GET[$name];
    }

    public static function check($name)
    {
        return isset($_GET[$name]);
    }
}