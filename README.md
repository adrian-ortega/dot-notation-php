# Simple Dot Notation with PHP

Access array data with dot notation.

## Usage

	$data = [
		'first_name' => 'John',
		'title' => 'Doe',
		'company' => 'ACME',
		'age' => 36,
		'address' => [
			'street' => '123 Anywhere Street',
			'city' => 'Los Angeles',
			'state' => 'CA',
			'zip_code' => 90210
		]
	];
	
    $street = DotNotation::parse('address.street', $data);
	
	// outputs 123 Anywhere Street
	echo $street