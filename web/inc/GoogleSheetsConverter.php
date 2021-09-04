<?php
class GoogleSheetsConverter
{
    private $originalUrl;
    private $parsedUrl;
    private $headings;
    private $headers;
    private $type;
    private $parsedData;

    function __construct($url, $headings = 1, $type = 'json') {
        if ( (strlen($url) > 0) && (strpos($url, 'https://docs.google.com/spreadsheets/d/') === 0) ) {
            $this->originalUrl = $url;
            $this->headings = $headings;
            $this->type = $type;
            $this->parseUrl();
            $this->parseData();
            $this->returnData();
        } else {
            echo 'Please provide valid url.';
        }
    }

    private function parseUrl() {
        if (preg_match('/d\/(.*?)\/edit((#gid=(.*?))|(\?usp=sharing))$/', $this->originalUrl, $match)) {
            if (isset($match[2]) && $match[2] == '?usp=sharing') {
                $this->parsedUrl = str_replace('/edit?usp=sharing', '/export?format=csv&id='.$match[1].'&gid=0', $this->originalUrl);
            } else {
                $this->parsedUrl = str_replace('/edit#gid='.$match[4], '/export?format=csv&id='.$match[1].'&gid='.$match[4], $this->originalUrl);
            }
        }
    }

    private function parseData() {
        $rows = array_map(function($v) { 
            return str_getcsv($v, ","); 
        }, file($this->parsedUrl));

        if ($this->headings == 1) {
            $this->headers = array_shift($rows);

            foreach($rows as $row) {
                $data[] = array_combine($this->headers, $row);
            }

            $this->parsedData = $data;
        } else {
            $this->parsedData = $rows;
        }
    }

    private function returnData() {
        switch ($this->type) {
            case 'json':
                header('Content-type: application/json');
                echo json_encode($this->parsedData);
                break;

            case 'csv':
                header('Content-Type: application/csv; charset=UTF-8');
                header('Content-Disposition: attachment; filename="data.csv";');
                $f = fopen('php://output', 'w');

                if ($this->headings == 1) {
                    fputcsv($f, $this->headers, ';');
                }

                foreach ($this->parsedData as $line) {
                    fputcsv($f, $line, ';');
                }
                break;
            
            default:
                break;
        }
    }
}
?>