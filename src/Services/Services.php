<?php
/**
 * Scabbia2 Services Component
 * https://github.com/eserozvataf/scabbia2
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link        https://github.com/eserozvataf/scabbia2-services for the canonical source repository
 * @copyright   2010-2016 Eser Ozvataf. (http://eser.ozvataf.com/)
 * @license     http://www.apache.org/licenses/LICENSE-2.0 - Apache License, Version 2.0
 */

namespace Scabbia\Services;

use ArrayAccess;
use InvalidArgumentException;

/**
 * Service container and registry
 *
 * @package     Scabbia\Services
 * @author      Eser Ozvataf <eser@ozvataf.com>
 * @since       2.0.0
 */
class Services implements ArrayAccess
{
    /** @type Services    $default   default service container */
    public static $default = null;

    /** @type array       $services  shared service objects */
    protected $services = [];


    /**
     * Returns the instance of default service container
     *
     * @return Services default service container
     */
    public static function getCurrent()
    {
        if (static::$default === null) {
            static::$default = new Services();
        }

        return static::$default;
    }

    /**
     * Sets a service definition
     *
     * @param string    $uId               name of the service
     * @param mixed     $uValue            any value
     *
     * @return void
     */
    public function offsetSet($uId, $uValue)
    {
        $this->services[$uId] = [$uValue, true];
    }

    /**
     * Sets a factory function in order to generate service instances
     *
     * @param string    $uName             name of the service
     * @param callable  $uCallback         callback generates service instances
     *
     * @return void
     */
    public function setFactory($uName, $uCallback)
    {
        $this->services[$uName] = [$uCallback, false];
    }

    /**
     * Sets a factory function in order to generate service instances
     *
     * @param string    $uName             name of the service
     * @param callable  $uCallback         callback generates service instances
     *
     * @throws InvalidArgumentException if the service is not defined
     * @return void
     */
    public function decorate($uName, $uCallback)
    {
        if (!isset($this->services[$uName])) {
            throw new InvalidArgumentException(sprintf("Service '%s' is not defined.", $uName));
        }

        $tService = $this->services[$uName];
        $tClosure = function () use ($tService, $uCallback) {
            // it's a shared instance, not a factory.
            if ($tService[1] === true) {
                $tValue = $tService[0];
            } else {
                $tValue = call_user_func($tService[0]);
            }

            return call_user_func($uCallback, $tValue);
        };

        $this->services[$uName] = [$tClosure, false];
    }

    /**
     * Gets the service instance or invokes factory callback if the service is defined
     *
     * @param string    $uId               name of the service
     *
     * @throws InvalidArgumentException if the service is not defined
     * @return mixed the service instance
     */
    public function offsetGet($uId)
    {
        if (!isset($this->services[$uId])) {
            throw new InvalidArgumentException(sprintf("Service '%s' is not defined.", $uId));
        }

        $tService = $this->services[$uId];

        // it's a shared instance, not a factory.
        if ($tService[1] === true) {
            return $tService[0];
        }

        return call_user_func($tService[0]);
    }

    /**
     * Checks if service is defined
     *
     * @param string    $uId               name of the service
     *
     * @return bool
     */
    public function offsetExists($uId)
    {
        return isset($this->services[$uId]);
    }

    /**
     * Unsets a service
     *
     * @param string    $uId               name of the service
     *
     * @return void
     */
    public function offsetUnset($uId)
    {
        unset($this->services[$uId]);
    }
}
