<?php

namespace CoreBundle\Dumper;

use CoreBundle\Adapter\AgentApiCode;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class ApiCodeDumper
 * @package CoreBundle\Dumper
 */
class ApiCodeDumper
{
    /**
     * @var EngineInterface
     */
    private $engine;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @param EngineInterface   $engine         The engine.
     * @param FileSystem        $filesystem     The file system.
     */
    public function __construct(
        EngineInterface $engine,
        Filesystem $filesystem
    ) {
        $this->engine         = $engine;
        $this->filesystem     = $filesystem;
    }
    /**
     * Dump all api code.
     *
     * @param string $target Target directory.
     */
    public function dump($target = 'web/js')
    {
        $file = $target. '/' .'api-codes.js';
        $this->filesystem->remove($file);
        $this->filesystem->touch($file);
        $data = array('codes'=>(new \ReflectionClass(AgentApiCode::class))->getConstants());
        file_put_contents(
            $file,
            $this->engine->render('@Core/templates/api-codes.js.twig', $data)
        );
    }
}