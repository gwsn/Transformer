## Transformer Package

## Installation

Require this package
```
composer require gwsn/transformer
```

## Usage Examples
Include the Transformer class:

`use Gwsn\Transformer\Transformer;`

Our sample source:
```
$source = [
    [
        'id' => '1',
        'name' => 'Test 1',
        'type' => 'text',
        'text' => 'Some text written by Cicero that's used to fill spaces on.'
    ],
    [
        'id' => '2',
        'name' => 'Test 2',
        'type' => 'short-text',
        'text' => 'The reason why it is difficult to understand is to draw attention away from the words on a page and to focus it on the design instead.'
    ],
    [
        'id' => '3',
        'name' => 'Test 3',
        'type' => 'text',
        'text' => 'It's also useful for filling spaces where text should be because its words are about the same length as normal English writing.'
    ],
];
```

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
