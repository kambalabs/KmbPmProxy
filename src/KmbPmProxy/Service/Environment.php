<?php
/**
 * @copyright Copyright (c) 2014 Orange Applications for Business
 * @link      http://github.com/kambalabs for the sources repositories
 *
 * This file is part of Kamba.
 *
 * Kamba is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * Kamba is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Kamba.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace KmbPmProxy\Service;

use KmbDomain\Model;
use KmbPmProxy\Client;
use KmbPmProxy\Exception\RuntimeException;
use Zend\Stdlib\Hydrator\HydratorInterface;

class Environment implements EnvironmentInterface
{
    /** @var HydratorInterface */
    protected $environmentHydrator;

    /** @var \KmbPmProxy\Client */
    protected $pmProxyClient;

    /**
     * Create or update an environment on the Puppet Master
     *
     * @param Model\EnvironmentInterface $environment
     * @param Model\EnvironmentInterface $cloneFrom
     * @return Environment
     * @throws RuntimeException
     */
    public function save(Model\EnvironmentInterface $environment, Model\EnvironmentInterface $cloneFrom = null)
    {
        $content = $this->getEnvironmentHydrator()->extract($environment);
        if ($cloneFrom != null) {
            $content['cloneFrom'] = strval($cloneFrom->getNormalizedName());
        }
        $this->pmProxyClient->put('/environments/' . $environment->getNormalizedName(), $content);
        if ($environment->hasChildren()) {
            foreach ($environment->getChildren() as $child) {
                /** @var Model\EnvironmentInterface $child */
                if ($cloneFrom) {
                    $this->save($child, $cloneFrom->getChildByName($child->getName()));
                } else {
                    $this->save($child);
                }
            }
        }
        return $this;
    }

    /**
     * Remove an environment on the Puppet Master
     *
     * @param Model\EnvironmentInterface $environment
     * @return Environment
     */
    public function remove(Model\EnvironmentInterface $environment)
    {
        $this->pmProxyClient->delete('/environments/' . $environment->getNormalizedName());
        if ($environment->hasChildren()) {
            foreach ($environment->getChildren() as $child) {
                /** @var Model\EnvironmentInterface $child */
                $this->remove($child);
            }
        }
        return $this;
    }

    /**
     * Set EnvironmentHydrator.
     *
     * @param HydratorInterface $environmentHydrator
     * @return Environment
     */
    public function setEnvironmentHydrator($environmentHydrator)
    {
        $this->environmentHydrator = $environmentHydrator;
        return $this;
    }

    /**
     * Get EnvironmentHydrator.
     *
     * @return HydratorInterface
     */
    public function getEnvironmentHydrator()
    {
        return $this->environmentHydrator;
    }

    /**
     * Set PMProxy Client.
     *
     * @param Client $pmProxyClient
     * @return Environment
     */
    public function setPmProxyClient($pmProxyClient)
    {
        $this->pmProxyClient = $pmProxyClient;
        return $this;
    }

    /**
     * Get PMProxy Client.
     *
     * @return Client
     */
    public function getPmProxyClient()
    {
        return $this->pmProxyClient;
    }
}
