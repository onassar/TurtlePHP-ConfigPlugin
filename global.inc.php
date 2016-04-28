<?php

    /**
     * getConfig
     * 
     * @access public
     * @return mixed
     */
    function getConfig()
    {
        $args = func_get_args();
        return call_user_func_array(
            array('\Plugin\Config', 'retrieve'),
            $args
        );
    }