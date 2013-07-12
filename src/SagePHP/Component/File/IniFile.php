<?php
namespace SagePHP\Component\File;

/**
 * reads and writes ini files.
 *
 * unlike php functions this keeps the original values (not converting On to 1, etc...)
 */
class IniFile
{
    /**
     * the file to read/write to
     *
     * @var \SplFileInfo
     */
    private $file;

    private $data = array();

    /**
     * @param \SplFileInfo $file
     */
    public function __construct(\SplFileInfo $file)
    {
        $this->setFile($file);
    }

    /**
     * Gets the the file to read/write to.
     *
     * @return \SplFileInfo
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Sets the the file to read/write to.
     *
     * @param \SplFileInfo $file the file
     *
     * @return self
     */
    public function setFile(\SplFileInfo $file)
    {
        $this->file = $file;

        return $this;
    }

    private function parse()
    {
        $conten
    }

    public function load()
    {

    }

    public function get($key, $section = null)
    {

    }

    public function has($key, $section = null)
    {

    }

    public function set($key, $section = null)
    {

    }
}
