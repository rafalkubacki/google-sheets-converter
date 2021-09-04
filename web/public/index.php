<?php
    if (isset($_GET['url'])) {
        require_once '../inc/GoogleSheetsConverter.php';
        $GSC = new GoogleSheetsConverter($_GET['url'], $_GET['headings'], $_GET['type']);
    } else {
?>
<form method="GET">
    <label>
        <span>Google Sheets url:</span>
        <input name="url" type="text" placeholder="You Google Sheets share url">
    </label>
    <div>
        Contains headings?
        <label><input name="headings" type="radio" value="1" checked>Yes</label>
        <label><input name="headings" type="radio" value="0">No</label>
    </div>
    <div>
        Export type:
        <label><input name="type" type="radio" value="json" checked>JSON</label>
        <label><input name="type" type="radio" value="csv">CSV</label>
    </div>
    <button type="submit">Convert</button>
</form>
<?php
    }
?>