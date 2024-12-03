<?php

declare(strict_types=1);

/**
 * PSR-4 Autoloader Implementation
 * 
 * This file implements a PSR-4 compliant autoloader for dynamic class loading.
 * It maps namespaces to directories and loads classes accordingly.
 * 
 * @package Tiboitel\Camagru;
 */

namespace Tiboitel\Camagru;

class Autoloader
{
    /**
     * @var array<string, string> Namespace-to-directory mapping.
     */
    private array $prefixes = [];

    /**
     * Register the autoloader with SPL.
     */
    public function register(): void
    {
        spl_autoload_register([$this, 'loadClass']);
    }

    /**
     * Add a namespace-to-directory mapping.
     * 
     * @param string $prefix The namespace prefix.
     * @param string $baseDir The base directory for the namespace.
     * @param bool $prepend Whether to prepend the base directory.
     */
    public function addNamespace(string $prefix, string $baseDir, bool $prepend = false): void
    {
        // Normalize namespace prefix and base directory
        $prefix = trim($prefix, '\\') . '\\';
        $baseDir = rtrim($baseDir, DIRECTORY_SEPARATOR) . '/';

        // Initialize the prefix array if not set
        if (!isset($this->prefixes[$prefix])) {
            $this->prefixes[$prefix] = [];
        }

        // Prepend or append the base directory
        if ($prepend) {
            array_unshift($this->prefixes[$prefix], $baseDir);
        } else {
            $this->prefixes[$prefix][] = $baseDir;
        }
    }

    /**
     * Load the class file for a given class name.
     * 
     * @param string $class The fully qualified class name.
     * @return void
     */
    public function loadClass(string $class): void
    {
        // Extract namespace prefix from the class name
        $prefix = $class;
        while (false !== $pos = strrpos($prefix, '\\')) {
            $prefix = substr($class, 0, $pos + 1);
            $relativeClass = substr($class, $pos + 1);

            // Attempt to load the mapped file
            $mappedFile = $this->loadMappedFile($prefix, $relativeClass);
            if ($mappedFile) {
                return;
            }

            $prefix = rtrim($prefix, '\\');
        }
    }

    /**
     * Load the mapped file for a namespace prefix and relative class name.
     * 
     * @param string $prefix The namespace prefix.
     * @param string $relativeClass The relative class name.
     * @return bool True if the file was loaded, false otherwise.
     */
    private function loadMappedFile(string $prefix, string $relativeClass): bool
    {
        // Check if the namespace prefix is registered
        if (!isset($this->prefixes[$prefix])) {
            return false;
        }

        // Iterate through base directories for the prefix
        foreach ($this->prefixes[$prefix] as $baseDir) {
            $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

            // If file exists, include it
            if (file_exists($file)) {
                require $file;
                return true;
            }
        }

        return false;
    }
}

