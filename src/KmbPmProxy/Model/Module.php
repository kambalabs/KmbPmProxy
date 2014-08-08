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

class Module
{
    /** @var string */
    protected $name;

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

    /**
     * Set Name.
     *
     * @param string $name
     * @return Module
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
     * Set Version.
     *
     * @param string $version
     * @return Module
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
     * Set Source.
     *
     * @param string $source
     * @return Module
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
     * @return Module
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
     * @return Module
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
     * @return Module
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
     * @return Module
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
     * @return Module
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
     * @return Module
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
}
