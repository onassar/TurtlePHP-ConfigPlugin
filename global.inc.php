<?php

    /**
     * getConfig
     * 
     * @access  public
     * @param   array $keys,...
     * @return  mixed
     */
    function getConfig(... $keys)
    {
        $params = $keys;
        $callback = array('\Plugin\Config', 'retrieve');
        $value = call_user_func_array($callback, $params);
        return $value;
    }
