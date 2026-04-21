<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Bank</title>

    <link rel="stylesheet" href="cssstyle.css">

    <?php
        /**
         * 2. DYNAMIC PAGE-SPECIFIC STYLES
         * This detects the current filename (e.g., 'index') 
         * and looks for 'css/index.css'
         */
        $currentPage = basename($_SERVER['PHP_SELF'], ".php");
        $pageStylePath = "css/" . $currentPage . ".css";

        // Only add the link if the CSS file actually exists in the /css folder
        if (file_exists($pageStylePath)) {
            echo '<link rel="stylesheet" href="' . $pageStylePath . '">';
        }
    ?>
</head>
<body>
    