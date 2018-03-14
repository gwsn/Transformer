

### Mappings

```
$mapping = [
    'guid' => 'id',
    'slug' => 'name',
    'type' => 'type',
    'text' => 'text',
];

$target = Transformer::run($source, Transformer::BuildMapping($mapping), []);
```
