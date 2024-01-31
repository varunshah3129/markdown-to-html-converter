<?php
function markdownToHTML($markdown) {
    // Convert Markdown headings
    for ($i = 6; $i > 0; $i--) {
        $markdown = preg_replace('/^' . str_repeat('#', $i) . ' (.*)/m', "<h$i>$1</h$i>", $markdown);
    }

    // Convert Markdown links
    $markdown = preg_replace('/\[(.*?)\]\((.*?)\)/', '<a href="$2">$1</a>', $markdown);

    // Wrap non-heading lines in <p> tags
    $markdown = '<p>' . preg_replace('/\n{2,}/', '</p><p>', trim($markdown)) . '</p>';

    // Remove <p> tags from around headings
    $markdown = preg_replace('/<p>(<h[1-6].*?<\/h[1-6]>)<\/p>/', '$1', $markdown);

    return $markdown;
}

function createUniqueHtmlFilename() {
    $timestamp = time();
    return "converted_$timestamp.html";
}

if (php_sapi_name() == 'cli') {

    if ($argc < 2) {
        echo "Usage: php script.php [Markdown file]\n";
        exit(1);
    }

    $markdownFile = $argv[1];
    if (!file_exists($markdownFile)) {
        echo "File not found: $markdownFile\n";
        exit(1);
    }

    $markdownContent = file_get_contents($markdownFile);
    $htmlContent = markdownToHTML($markdownContent);

    $outputHtmlFile = pathinfo($markdownFile, PATHINFO_FILENAME) . '.html';
    file_put_contents($outputHtmlFile, $htmlContent);

    echo "Converted to HTML: $outputHtmlFile\n";
} else {
    // Web mode logic
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['markdown'])) {
        $markdownContent = $_POST['markdown'];
        $htmlContent = markdownToHTML($markdownContent);

        $outputHtmlFile = createUniqueHtmlFilename();
        file_put_contents($outputHtmlFile, $htmlContent);

        echo json_encode([
            'filename' => $outputHtmlFile,
            'htmlContent' => $htmlContent
        ]);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request']);
    }
}