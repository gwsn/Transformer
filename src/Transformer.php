<?php
namespace Gwsn\LumenTransformer\Models;

/**
 * Class Transformer
 *
 * @package Gwsn\LumenTransformer\Models
 */
class Transformer
{

    private function __construct() {
        // Not allowed to call this function
    }

    public static function BuildMapping(array $mapping = []) {
        return (new DefaultMapping())->setMapping($mapping);
    }

    /**
     * Insert a array of objects
     *
     * @param mixed $source Array of arrays (if array of objects will be converted to array of arrays)
     * @param MappingInterface $mapping
     * @param mixed $output
     * @return array
     */
    public static function run($source = null, MappingInterface $mapping, $output = null) {
        $data = [];

        foreach($source as $src) {
            $data[] = self::runOnce($src, $mapping, $output);
        }

        return $data;
    }

    /**
     * @param mixed $source
     * @param MappingInterface $mapping
     * @param mixed $output
     * @return Object
     */
    public static function runOnce($source = null, MappingInterface $mapping, $output = null) {
        if(!is_object($source) && !is_array($source)) {
            throw new \InvalidArgumentException('The parameter Source should be a Object or Array '.typeOf($source).' is not a valid type.');
        }

        if(empty($mapping->getMapping())) {
            throw new \InvalidArgumentException('The $mapping->getMapping() is not returning a valid mapping, please provide a valid mapping.');
        }

        if($output === null) {
            $output = [];
        }

        if(is_object($source)) {
            $source = json_decode(json_encode($source), true);
        }

        return self::transformData($source, $mapping, $output);
    }

    /**
     * Helper function to transform data with a mapping
     *
     * @param mixed $source
     * @param MappingInterface $mapping
     * @param mixed $output
     *
     * @return mixed
     */
    private static function transformData(Array $source, MappingInterface $mapping, $output) {
        $data = [];
        $mappingArray = $mapping->getMapping();

        foreach($mappingArray as $key => $value) {
            $callback = null;
            $found = null;
            $search = null;

            // Set Default value
            if(is_array($value) && count($value) === 3) {
                $data[$key] = $value[2];
            }

            // Check if Callback Exists
            if (is_array($value) && count($value) >= 2) {
                $search = $value[0];
                if(is_callable($mapping, $value[1])) {
                    $callback = $value[1];
                }

            } elseif(is_array($value) && count($value) === 1) {
                $search = $value[0];

            } else {
                $search = $value;
            }

            // Get the value key form original data
            if(strpos( (string) $search, '.') !== false) {
                $found = self::arrayGet($source, $search);
            } elseif($search !== null && isset($source[$search])) {
                $found = $source[$search];
            }

            // Check if there need to be a callback.
            if(!empty($found)) {
                if(!empty($callback)) {
                    $data[$key] = call_user_func([$mapping, $callback], $found, $source);
                } else {
                    $data[$key] = $found;
                }
            }
        }

        if(is_object($output)) {
            return self::populateObject($output, $data);
        }

        if(is_array($output) && empty($output)) {
            return $data;
        }

        if(is_array($output)){
            $output[] = $data;
        }

        return $output;
    }

    /**
     * Helper function to set Array data to a object.
     *
     * @param Object $output
     * @param mixed $source
     * @return Object
     */
    private static function populateObject($output, $source) {
        $source = json_decode(json_encode($source), true);

        foreach($source as $key => $value) {
            $method = self::createMethodNames($key);

            // Changed method_exists() to is_callable() because of the magic functions
            // @source: http://php.net/manual/en/function.method-exists.php
            if(is_callable([$output, $method])) {
                call_user_func([$output, $method], $value);
            }
        }

        return $output;
    }

    /**
     * Helper function to call a variable setter.
     *
     * @param string $key
     * @param string $prefix
     * @return mixed
     */
    private static function createMethodNames($key, $prefix = 'set') {
        return $prefix.str_replace(' ', '', ucwords(strtolower(str_replace('_', ' ',$key))));
    }

    /**
     * Helper function to get an item from an array using "dot" notation.
     *
     * @param array $array
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    private static function arrayGet($array, $key, $default = null) {
        if (is_null($key))
            return $array;

        if (isset($array[$key]))
            return $array[$key];

        foreach (explode('.', $key) as $segment) {
            if ( ! is_array($array) || ! array_key_exists($segment, $array))
                return $default;

            $array = $array[$segment];
        }
        return $array;
    }
}