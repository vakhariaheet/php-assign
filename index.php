<?php
$MAIN_DIR = 'src';

// Set the base directory to '/files'
$baseDir = realpath(__DIR__.'/'.$MAIN_DIR);
$currentMode = 'home';
$currentDir = $baseDir;
$currentFiles = [];
$currentFolders = [];
// Function to recursively list all files and directories
function listFiles($dir, $baseDir)
{
    global $currentFiles, $currentFolders, $MAIN_DIR;
    if ($handle = opendir($dir)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            $current = [
                'name' => $entry,
                'path' => $dir.DIRECTORY_SEPARATOR.$entry,
                'relativePath' => str_replace(
                    $baseDir,
                    '',
                    $dir.DIRECTORY_SEPARATOR.$entry
                ),
                'displayPath' => '/'.$MAIN_DIR.
                    str_replace(
                        $baseDir,
                        '',
                        $dir.DIRECTORY_SEPARATOR.$entry
                    ),
                'isDir' => is_dir($dir.DIRECTORY_SEPARATOR.$entry),
                'backpath' => $dir == $baseDir ? '' : str_replace($baseDir, '', $dir),
            ];
            if ($current['isDir']) {
                $currentFolders[] = $current;
            } else {
                $currentFiles[] = $current;
            }
        }
        closedir($handle);
    }
}

// Handle the search functionality
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
$dirToScan = isset($_GET['dir'])
    ? realpath($baseDir.DIRECTORY_SEPARATOR.$_GET['dir'])
    : $baseDir;

// Ensure the directory to scan is within the base directory
if (strpos($dirToScan, $baseDir) !== 0) {
    $dirToScan = $baseDir;
}

// Function to search files and directories
function searchFilesAndFolders($dir, $baseDir, $searchQuery)
{
    $folders = [];
    $files = [];
    global $MAIN_DIR;
    if ($handle = opendir($dir)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != '.' && $entry != '..') {
                $fullPath = $dir.DIRECTORY_SEPARATOR.$entry;
                $relativePath = str_replace($baseDir, '', $fullPath);
                $displayPath = '/'.$MAIN_DIR.$relativePath;
                $isDir = is_dir($fullPath);
                $backPath =
                    $dir == $baseDir ? '' : str_replace($baseDir, '', $dir);

                $current = [
                    'name' => $entry,
                    'path' => $fullPath,
                    'relativePath' => $relativePath,
                    'displayPath' => $displayPath,
                    'isDir' => $isDir,
                    'backpath' => $backPath,
                ];

                if ($isDir) {
                    // Check if the folder name matches the search query
                    if (stripos($entry, $searchQuery) !== false) {
                        $folders[$relativePath] = $current;
                    }
                    // Recursive call
                    $results = searchFilesAndFolders(
                        $fullPath,
                        $baseDir,
                        $searchQuery
                    );
                    $folders = array_merge($folders, $results['folders']);
                    $files = array_merge($files, $results['files']);
                } else {
                    // Check if the file name matches the search query
                    if (stripos($entry, $searchQuery) !== false) {
                        $files[$relativePath] = $current;
                    }
                }
            }
        }
        closedir($handle);
    }

    return ['folders' => $folders, 'files' => $files];
}

// Display the current folder
$currentFolder =
    $dirToScan === $baseDir ? 'Home' : str_replace($baseDir, '', $dirToScan);
$noResults = false;

// Display search results or directory contents
if (!empty($searchQuery)) {
    $results = searchFilesAndFolders($dirToScan, $baseDir, $searchQuery);

    if (!empty($results['folders']) || !empty($results['files'])) {
        if (!empty($results['folders'])) {
            $currentFolders = $results['folders'];
        }

        if (!empty($results['files'])) {
            $currentFiles = $results['files'];
        }
    } else {
        $noResults = true;
    }
} else {
    listFiles($dirToScan, $baseDir);
}
function generateBreadcrumbs($currentDir, $baseDir)
{
    $breadcrumbs = [];
    global $MAIN_DIR;
    // Add the "Home" breadcrumb
    $breadcrumbs[] = [
        'name' => 'Home',
        'path' => '',
        'displayPath' => '/'.$MAIN_DIR,
    ];

    $relativePath = str_replace($baseDir, '', $currentDir);
    $pathParts = explode(
        DIRECTORY_SEPARATOR,
        trim($relativePath, DIRECTORY_SEPARATOR)
    );
    $accumulatedPath = '';

    foreach ($pathParts as $index => $part) {
        if (!empty($part)) {
            $accumulatedPath .= DIRECTORY_SEPARATOR.$part;
            $displayPath = '/'.$MAIN_DIR.$accumulatedPath;
            $breadcrumbs[] = [
                'name' => $part,
                'path' => $accumulatedPath,
                'displayPath' => $displayPath,
            ];
        }
    }

    return $breadcrumbs;
}

// Function to create a zip archive of a directory
function createZipArchive($source, $destination)
{
    if (!extension_loaded('zip') || !file_exists($source)) {
        return false;
    }

    $zip = new ZipArchive();
    if (!$zip->open($destination, ZipArchive::CREATE)) {
        return false;
    }

    $source = str_replace('\\', '/', realpath($source));

    if (is_dir($source) === true) {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file) {
            $file = str_replace('\\', '/', $file);

            // Ignore "." and ".." folders
            if (in_array(substr($file, strrpos($file, '/') + 1), ['.', '..'])) {
                continue;
            }

            $file = realpath($file);

            if (is_dir($file) === true) {
                $zip->addEmptyDir(str_replace($source.'/', '', $file.'/'));
            } elseif (is_file($file) === true) {
                $zip->addFromString(str_replace($source.'/', '', $file), file_get_contents($file));
            }
        }
    } elseif (is_file($source) === true) {
        $zip->addFromString(basename($source), file_get_contents($source));
    }

    return $zip->close();
}

// Handle download requests
if (isset($_GET['download'])) {
    $downloadPath = realpath($baseDir.DIRECTORY_SEPARATOR.$_GET['download']);

    // Ensure the download path is within the base directory
    if (strpos($downloadPath, $baseDir) === 0) {
        if (is_dir($downloadPath)) {
            // Create a temporary zip file
            $zipFile = tempnam(sys_get_temp_dir(), 'zip');
            if (createZipArchive($downloadPath, $zipFile)) {
                header('Content-Type: application/zip');
                header('Content-Disposition: attachment; filename="'.basename($downloadPath).'.zip"');
                header('Content-Length: '.filesize($zipFile));
                readfile($zipFile);
                unlink($zipFile); // Delete the temporary file
                exit;
            }
        } elseif (is_file($downloadPath)) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($downloadPath).'"');
            header('Content-Length: '.filesize($downloadPath));
            readfile($downloadPath);
            exit;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bulma.css">
    <title>
        Webbound File Manager
    </title>

    <style>

        .icon {
            margin-right: 5px;
        }

        .error-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        body {
            padding: 10px;
        }

        .accordion {
            width: 90%;
            max-width: 1000px;
            margin: 2rem auto;
        }
        .buttons {
            align-items:unset;
        }
        .accordion-item {
            background-color: transparent;
            color: #fff;
            margin: 1rem 0;
            border-radius: 0.5rem;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.25);
        }

        .accordion-item-header {
            padding: 0.5rem 3rem 0.5rem 1rem;
            min-height: 3.5rem;
            line-height: 1.25rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            position: relative;
            cursor: pointer;
        }

        .accordion-item-header::after {
            content: "\002B";
            font-size: 2rem;
            position: absolute;
            right: 1rem;
        }

        .accordion-item-header.active::after {
            content: "\2212";
        }

        .accordion-item-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.2s ease-out;
        }

        .accordion-item-body-content {
            padding: 1rem;
            line-height: 1.5rem;
            border-top: 1px solid;
            border-image: linear-gradient(to right, transparent, #34495e, transparent) 1;
        }
        .buttons {
            display: flex;
            align-items: unset;
        }
    </style>
    <script src="https://kit.fontawesome.com/42fc040697.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
</head>

<body>
    <div class="container">
        <div class="hero">
            <div class="hero-body">
                <h1 class="title">Webbound</h1>
                <h2 class="subtitle">File Manager</h2>
                <p class="content">
                    Welcome to Webbound File Manager! You can browse through the files and folders in the
                    <code>
                        /<?php echo $MAIN_DIR; ?>
                    </code> directory.
                </p>
            </div>

        </div>

    </div>

    <?php if ($dirToScan != $baseDir) {
        echo '<div class="box">';
        echo '<nav class="breadcrumb has-bullet-separator" aria-label="breadcrumbs">';
        echo '<ul>';

        $breadcrumbs = generateBreadcrumbs($dirToScan, $baseDir);
        foreach ($breadcrumbs as $index => $breadcrumb) {
            if ($index === count($breadcrumbs) - 1) {
                echo '<li class="is-active "><a href="#" aria-current="page">'.
                    htmlspecialchars($breadcrumb['name']).
                    '</a></li>';
            } else {
                echo '<li><a href="?dir='.
                    urlencode($breadcrumb['path']).
                    '&search='.
                    urlencode($searchQuery).
                    '">'.
                    htmlspecialchars($breadcrumb['name']).
                    '</a></li>';
            }
        }

        echo '</ul>';
        echo '</nav>';
        echo '</div>';
    } ?>


    <form method="GET" class="field has-addons">

        <div class="control is-expanded">
            <input class="input" type="text" name="search" placeholder="Search Files and Folders"
                value="<?php echo htmlspecialchars($searchQuery); ?>">
        </div>
        <div class="control">
            <button class="button is-info">
                Search
            </button>
        </div>
    </form>
    <?php if ($noResults) {
        echo '<div class="error-container">';
        echo '<dotlottie-player ';
        echo 'src="https://lottie.host/6fa670aa-d4ce-4c48-b631-513623b99a60/u9CE91aOJE.json" ';
        echo 'background="transparent" ';
        echo 'speed="1" ';
        echo 'style="width:300px;height:300px" ';
        echo 'direction="1" ';
        echo 'playmode="normal" ';
        echo 'loop ';
        echo 'autoplay ';
        echo ' ></dotlottie-player>';
        echo '<h1 class="title is-1">File Lost!</h1>';
        echo '<p class="subtitle is-5">';
        echo 'Oh no! Looks like our robot lost its way. The file you\'re looking for might ';
        echo 'have gone on a coffee break!';
        echo '</p>';
        echo '</div>';
        echo '';
    } ?>
    <?php if (!empty($currentFolders)) {
        echo '<h3 class="subtitle is-3">Folders:</h3>';
    } ?>

        <div class="fixed-grid has-6-cols has-3-cols-mobile">
            <div class="grid">
                <?php foreach ($currentFolders as $folder) {
                    echo '<div class="cell">';
                    echo '<div class="buttons has-addons">';
                    echo '<a class="button entry" href="?dir='.urlencode($folder['relativePath']).'"><i class="fa-solid fa-folder" style="color: #63E6BE; margin-right:5px;"></i> '.htmlspecialchars($folder['name']).'</a>';
                    echo '<a class="button is-info" href="?download='.urlencode($folder['relativePath']).'" title="Download Folder"><i class="fa-solid fa-download"></i></a>';
                    echo '</div>';
                    echo '</div>';
                } ?>
            </div>
        </div>

        <?php if (!empty($currentFiles)) {
            echo '<h3 class="subtitle is-3">Files:</h3>';
        } ?>
        <div class="fixed-grid has-6-cols has-3-cols-mobile">
            <div class="grid">
                <?php foreach ($currentFiles as $file) {
                    echo '<div class="cell">';
                    echo '<div class="buttons has-addons">';
                    echo '<a class="button entry" href="'.htmlspecialchars($file['displayPath']).'"><i class="fa-solid fa-file" style="color: #63e6be; margin-right:5px;"></i> '.htmlspecialchars($file['name']).'</a>';
                    echo '<a class="button is-info" href="?download='.urlencode($file['relativePath']).'" title="Download File"><i class="fa-solid fa-download"></i></a>';
                    echo '</div>';
                    echo '</div>';
                } ?>
            </div>
        </div>

   
    <script>
        const accordionItemHeaders = document.querySelectorAll(".accordion-item-header");

        accordionItemHeaders.forEach(accordionItemHeader => {
            accordionItemHeader.addEventListener("click", event => {
                accordionItemHeader.classList.toggle("active");
                const accordionItemBody = accordionItemHeader.nextElementSibling;
                if (accordionItemHeader.classList.contains("active")) {
                    accordionItemBody.style.maxHeight = accordionItemBody.scrollHeight + "px";
                }
                else {
                    accordionItemBody.style.maxHeight = 0;
                }

            });
        });
    </script>
</body>

</html>