<?php
namespace Gwsn\Transformer\Mapping;


abstract class BaseMapping implements MappingInterface
{
    /**
     * @var array $mapping
     */
    protected $mapping = [];

    /**
     * @return array
     */
    public function getMapping(): array
    {
        return $this->mapping;
    }

    /**
     * @param array $mapping
     * @return BaseMapping
     */
    public function setMapping(array $mapping = []): BaseMapping
    {
        $this->mapping = $mapping;
        return $this;
    }

    /**
     * Build a mapping based on properties of a entity.
     *
     * @param object $source
     * @param array $blacklist
     * @return array
     */
    protected function buildMappingOnObject($source = null, array $blacklist = []):array {
        if(!is_object($source)) {
            return [];
        }

        try {
            $mapping = [];
            $reflection = new \ReflectionClass($source);
            $properties = $reflection->getProperties();

            foreach($properties as $key => $value) {
                if(!in_array($value->name, $blacklist))
                    $mapping[$value->name] = $value->name;

            }
            return $mapping;

        } catch (\Exception $exception) {
            return [];
        }
    }
}
