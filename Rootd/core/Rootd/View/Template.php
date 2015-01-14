<?php

/**
 * Template view class.
 *
 * @package   Rootd
 * @author    Rick Buczynski <me@rickbuczynski.com>
 * @copyright 2014 Rick Buczynski. All Rights Reserved.
 */

class Rootd_View_Template
    extends Rootd_View_Abstract
{

    protected $_area        = 'plugin';
    protected $_isAbsolute  = false;
    protected $_template    = '';

    /**
     * Render the view content from template.
     * 
     * @param string $content The pre-rendered output.
     * 
     * @return string
     */
    protected function _render($content = '')
    {
        try {
            $path = $this->getTemplatePath();

            ob_start();

            if ($path) {
                @include $path;
            }

            $content .= ob_get_contents();

            ob_end_clean();
        } catch(Exception $error) { }

        return $content;
    }

    /**
     * Get the view render area.
     * 
     * @return string
     */
    public function getArea()
    {
        return $this->_area;
    }

    /**
     * Get the view template.
     * 
     * @return string
     */
    public function getTemplate()
    {
        return $this->_template;
    }

    /**
     * Get the full template path.
     * 
     * @return string|false
     */
    public function getTemplatePath()
    {
        $path = null;

        if ($this->_isAbsolute) {
            if (file_exists($this->_template)) {
                $path = $this->_template;
            }
        } else {
            foreach (array($this->_area, 'theme', 'core') as $area) {
                $path = Rootd::getBasePath($area, $this->_template);

                if (file_exists($path)) {
                    return $path;
                }
            }
        }

        return $path;
    }

    /**
     * Set the view template.
     * 
     * @param string  $template   The template path (relative).
     * @param boolean $isAbsolute A flag to specify an absolute template path.
     *
     * @return Rootd_View_Template
     */
    public function setTemplate($template = '', $isAbsolute = false)
    {
        $this->_isAbsolute  = $isAbsolute;
        $this->_template    = $template;

        return $this;
    }

}