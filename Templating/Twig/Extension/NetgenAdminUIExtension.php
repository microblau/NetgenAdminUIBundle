<?php

namespace Netgen\Bundle\AdminUIBundle\Templating\Twig\Extension;

use Netgen\Bundle\AdminUIBundle\Templating\GlobalHelper;
use Closure;
use Twig_Extension;
use Twig_SimpleFunction;
use Twig_Extension_GlobalsInterface;
use eZPreferences;

class NetgenAdminUIExtension extends Twig_Extension implements Twig_Extension_GlobalsInterface
{
    /**
     * @var \Closure
     */
    protected $legacyKernel;

    /**
     * @var \Netgen\Bundle\AdminUIBundle\Templating\GlobalHelper
     */
    protected $globalHelper;

    /**
     * Constructor.
     *
     * @param \Closure $legacyKernel
     * @param \Netgen\Bundle\AdminUIBundle\Templating\GlobalHelper $globalHelper
     */
    public function __construct(Closure $legacyKernel, GlobalHelper $globalHelper)
    {
        $this->legacyKernel = $legacyKernel;
        $this->globalHelper = $globalHelper;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'netgen_admin_ui';
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction(
                'ezpreference',
                array($this, 'getLegacyPreference')
            ),
        );
    }

    /**
     * Returns eZ Publish Legacy ezpreference value.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getLegacyPreference($name)
    {
        $legacyKernel = $this->legacyKernel;

        return $legacyKernel()->runCallback(
            function () use ($name) {
                return eZPreferences::value($name);
            }
        );
    }

    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     */
    public function getGlobals()
    {
        return array('netgen_admin_ui' => $this->globalHelper);
    }
}