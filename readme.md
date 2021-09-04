# Google Sheets Converter

Convert Google Sheets data to other formats.

## How to use?

1. Require `GoogleSheetsConverter` class.
2. Call the class using `$GSC = new GoogleSheetsConverter($url, $headings, $type);` where:
`$url` (required) - Your Google Sheets url.
`$headings` (optional) - `1` if the first line contains headings, `0` if not. Default: `1`.
`$type` (optional) - One of export formats: `json` `csv`. Default: `json`.