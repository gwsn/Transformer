### Simple usage

```
$mapping = [
    'guid' => 'id',
    'slug' => 'name',
    'type' => 'type',
    'text' => 'text',
];

$target = Transformer::run($source, Transformer::BuildMapping($mapping));
```


### Array to Object

```
$mapping = [
    'guid' => 'id',
    'slug' => 'name',
    'type' => 'type',
    'text' => 'text',
];

class Dummy {
    public $guid;

    public $slug;

    public $type;

    public $text;
}

$target = Transformer::run($source, Transformer::BuildMapping($mapping), new Dummy());
```

### Array to Array

```
$mapping = [
    'guid' => 'id',
    'slug' => 'name',
    'type' => 'type',
    'text' => 'text',
];

$target = Transformer::run($source, Transformer::BuildMapping($mapping), []);
```
