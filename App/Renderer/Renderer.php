<?php

namespace App\Renderer;

use Smarty;


class Renderer
{
    protected static $smarty;

    protected Smarty $_smarty;

    /**какие то общие данные
     * @var array
     */
    protected $sharedData = [];

    public function __construct(Smarty $smarty)
    {
            $this->_smarty = $smarty;
    }

    public static function getSmarty()
    {

       if(is_null(static::$smarty)) {
            static::init();
        }

        return static::$smarty;
    }

    protected static function init()
    {
        $smarty = new Smarty();

        $smarty->template_dir = APP_DIR . '/templates';
        $smarty->compile_dir = APP_DIR . '/var/compile';
        $smarty->cache_dir = APP_DIR . '/var/cache';
        $smarty->config_dir = APP_DIR . '/var/configs';

        static::$smarty = $smarty;
    }

    /**
     * @param string $template
     * @param array $data
     * @return mixed|void|bool|string[]|string
     */
    public function render(string $template, array $data = [])
    {
        foreach ($this->sharedData as $key => $value) {
            $this->_smarty->assign($key, $value);
        }

        foreach ($data as $key => $value) {
            $this->_smarty->assign($key, $value);
        }

        return $this->_smarty->fetch($template);
    }

    public function addSharedData(string $key, $value)
    {
        $this->sharedData[$key] = $value;
    }
}