function convertMarkdown() {
    const markdownInput = document.getElementById('markdownInput').value;

    fetch('markdownToHtml.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'markdown=' + encodeURIComponent(markdownInput)
    })
        .then(response => response.json())
        .then(data => {
            if (data.htmlContent) {
                document.getElementById('htmlOutput').innerHTML = data.htmlContent;
            }
            if (data.filename) {
                console.log("HTML content saved to file:", data.filename);
            }
        })
        .catch(error => console.error('Error:', error));
}
