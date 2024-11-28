# Excel Date Converter

Excel Date Converter is a PHP utility package for handling and converting Excel-style date values as well as standard date formats. This package supports multiple date formats, including timestamps, and provides functionality to parse, convert, and format dates easily.

## Features

- Convert Excel-style serial date values to standard UNIX timestamps.
- Support for a wide range of standard date formats.
- Format dates into custom string representations.
- Easy to use and integrate into any PHP project.

## Installation

To use this package, you can install it via Composer:

```bash
composer require hypervix/execldateconverter
``` 

## Usage

```
// Convert Excel serial date to timestamp
$dateConverter = ExeclDateConverter::date(44561);
echo $dateConverter->format('Y-m-d'); // Output: 2022-01-01

// Convert a standard date format
$dateConverter = ExeclDateConverter::date('31-12-2023');
echo $dateConverter->format('Y/m/d'); // Output: 2023/12/31

```

## Supported Date Formats

This package supports the following date formats:

- d-m-Y (e.g., 31-12-2023)
- Y-m-d (e.g., 2023-12-31)
- Y/m/d (e.g., 2023/12/31)
- d/m/Y (e.g., 31/12/2023)
- M d, Y (e.g., Dec 31, 2023)
- d F Y (e.g., 31 December 2023)
- And many more!



For the full list of supported formats, refer to the source code in the ExeclDateConverter::possible_format() method.

## Requirements

- PHP >= 7.4
- Composer for installation


## Contributing

Contributions are welcome! If you'd like to contribute to this project, please follow these steps:

- Fork the repository.
- Create a new branch for your feature or bug fix.
- Commit your changes.
- Push your branch and open a pull request.

## License

This project is licensed under the MIT License. See the LICENSE file for more details.

- **Author:**  Jayanta Bhunia
- **Website:** https://hypervix.com/
- **Email:** bhuniajayant@gmail.com




