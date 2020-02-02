# Introduction

Badger is a VCard parsing library based on
[Pharse](https://github.com/serenitylabz/pharse), a Monadic parsing library.

## Usage

Create an instance of the parser with:

    use Badger\VCardParser;
    
    $vcardParser = new VCardParser();

Then, call parse on a string containing the VCard data:

    $result = $vcardParser->parse($data);

The result is a
[`PhatCats\LinkedList\LinkedList`](https://github.com/serenitylabz/phatcats/blob/master/src/LinkedList/LinkedList.php)
of
[`PhatCats\Tuple`](https://github.com/serenitylabz/phatcats/blob/master/src/Tuple.php)s. Each
element of this list represents a different way to parse the input data but in
this case there should only be zero (meaning could not parse) or one elements.
The first element of the tuple will be an instance of `Badger\VCard`.
