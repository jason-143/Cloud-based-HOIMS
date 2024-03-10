<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' | ' : ''; ?>Simple Web App</title>
    <style>
        /* Some basic styling for the layout */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }

        aside {
            background-color: #4CAF50;
            padding: 10px;
            color: white;
            width: 200px;
            box-sizing: border-box;
        }

        nav {
            display: flex;
            flex-direction: column;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 5px;
            margin-bottom: 5px;
        }

        nav a.active {
            background-color: #333;
        }

        section {
            padding: 20px;
            flex: 1;
        }
    </style>
</head>
<body>
    <aside>
        <h1>Simple Web App</h1>
        <nav>
            <a href="index.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], 'index.php') !== false) ? 'active' : ''; ?>">Home</a>
            <a href="members.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], 'members.php') !== false) ? 'active' : ''; ?>">Members</a>
            <!-- Add more links as needed -->
        </nav>
    </aside>
