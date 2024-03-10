<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Cell Example</title>
    <style>
        td {
            position: relative;
            padding-left: 100px; /* Adjust as needed for spacing */
        }

        td::before {
            content: attr(data-cell);
            position: absolute;
            left: 0;
            font-weight: bold;
        }
    </style>
</head>
<body>

<table>
    <tr>
        <td data-cell="Header 1">Value 1</td>
        <td data-cell="Header 2">Value 2</td>
        <td data-cell="Header 3">Value 3</td>
    </tr>
    <tr>
        <td data-cell="Header 4">Value 4</td>
        <td data-cell="Header 5">Value 5</td>
        <td data-cell="Header 6">Value 6</td>
    </tr>
    <tr>
        <td data-cell="Header 7">Value 7</td>
        <td data-cell="Header 8">Value 8</td>
        <td data-cell="Header 9">Value 9</td>
    </tr>
</table>

</body>
</html> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repeating Table Header</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
    </style>
</head>
<body>

<table>
    <thead>
        <tr>
            <th></th>
            <th>Header 1</th>
            <th>Header 2</th>
            <th>Header 3</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>Header</th>
            <td>Value 1</td>
            <td>Value 2</td>
            <td>Value 3</td>
        </tr>
        <tr>
            <th>Header</th>
            <td>Value 4</td>
            <td>Value 5</td>
            <td>Value 6</td>
        </tr>
        <tr>
            <th>Header</th>
            <td>Value 7</td> 
            <td>Value 8</td>
            <td>Value 9</td>
        </tr>
    </tbody>
</table>

</body>
</html>
