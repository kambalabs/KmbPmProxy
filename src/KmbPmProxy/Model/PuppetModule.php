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
namespace KmbPmProxy\Model;

class PuppetModule
{
    /** @var string */
    protected $name;

    /** @var boolean */
    protected $inherited;

    /** @var  boolean */
    protected $override;

    /** @var string */
    protected $version;

    /** @var string */
    protected $source;

    /** @var string */
    protected $projectPage;

    /** @var string */
    protected $issuesUrl;

    /** @var string */
    protected $author;

    /** @var string */
    protected $summary;

    /** @var string */
    protected $license;

    /** @var PuppetClass[] */
    protected $classes;

    /** @var  array */
    protected $availableVersions;

    /**
     * @param string $name
     * @param string $version
     */
    public function __construct($name = null, $version = null)
    {
        $this->setName($name);
        $this->setVersion($version);
    }

    /**
     * Set Name.
     *
     * @param string $name
     * @return PuppetModule
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get Name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Inherited.
     *
     * @param boolean $inherited
     * @return PuppetModule
     */
    public function setInherited($inherited)
    {
        $this->inherited = $inherited;
        return $this;
    }

    /**
     * Get Inherited.
     *
     * @return boolean
     */
    public function isInherited()
    {
        return $this->inherited;
    }

    /**
     * Set Override.
     *
     * @param boolean $override
     * @return PuppetModule
     */
    public function setOverride($override)
    {
        $this->override = $override;
        return $this;
    }

    /**
     * Get Override.
     *
     * @return boolean
     */
    public function isOverride()
    {
        return $this->override;
    }

    /**
     * Set Version.
     *
     * @param string $version
     * @return PuppetModule
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * Get Version.
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return boolean
     */
    public function isOnBranch()
    {
        return preg_match('/^[0-9.]+-[0-9]+-[a-fA-F0-9]{7}-.+$/', $this->version) ? true : false;
    }

    /**
     * Set Source.
     *
     * @param string $source
     * @return PuppetModule
     */
    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * Get Source.
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set ProjectPage.
     *
     * @param string $projectPage
     * @return PuppetModule
     */
    public function setProjectPage($projectPage)
    {
        $this->projectPage = $projectPage;
        return $this;
    }

    /**
     * Get ProjectPage.
     *
     * @return string
     */
    public function getProjectPage()
    {
        return $this->projectPage;
    }

    /**
     * Set IssuesUrl.
     *
     * @param string $issuesUrl
     * @return PuppetModule
     */
    public function setIssuesUrl($issuesUrl)
    {
        $this->issuesUrl = $issuesUrl;
        return $this;
    }

    /**
     * Get IssuesUrl.
     *
     * @return string
     */
    public function getIssuesUrl()
    {
        return $this->issuesUrl;
    }

    /**
     * Set Author.
     *
     * @param string $author
     * @return PuppetModule
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * Get Author.
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set Summary.
     *
     * @param string $summary
     * @return PuppetModule
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
        return $this;
    }

    /**
     * Get Summary.
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set License.
     *
     * @param string $license
     * @return PuppetModule
     */
    public function setLicense($license)
    {
        $this->license = $license;
        return $this;
    }

    /**
     * Get License.
     *
     * @return string
     */
    public function getLicense()
    {
        return $this->license;
    }

    /**
     * Set Classes.
     *
     * @param \KmbPmProxy\Model\PuppetClass[] $classes
     * @return PuppetModule
     */
    public function setClasses($classes)
    {
        $this->classes = $classes;
        return $this;
    }

    /**
     * Get Classes.
     *
     * @return \KmbPmProxy\Model\PuppetClass[]
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * Get Class.
     *
     * @param string $name
     * @return \KmbPmProxy\Model\PuppetClass
     */
    public function getClass($name)
    {
        if ($this->hasClasses()) {
            foreach ($this->getClasses() as $class) {
                if ($class->getName() === $name) {
                    return $class;
                }
            }
        }
        return null;
    }

    /**
     * @return bool
     */
    public function hasClasses()
    {
        return count($this->classes) > 0;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasClass($name)
    {
        return $this->getClass($name) !== null;
    }

    /**
     * Set AvailableVersions.
     *
     * @param array $availableVersions
     * @return PuppetModule
     */
    public function setAvailableVersions($availableVersions)
    {
        $this->availableVersions = $availableVersions;
        return $this;
    }

    /**
     * Get AvailableVersions.
     *
     * @return array
     */
    public function getAvailableVersions()
    {
        return $this->availableVersions;
    }

    /**
     * @param string $branch
     * @return string
     */
    public function getAvailableVersionMatchingBranch($branch)
    {
        foreach ($this->availableVersions as $version) {
            if (preg_match('/^[0-9.]+-[0-9]+-[a-fA-F0-9]{7}-'.$branch.'$/', $version)) {
                return $version;
            }
        }
    }
}
