<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" data-name="vs/editor/editor.main" href="./node_modules/monaco-editor/min/vs/editor/editor.main.css" />
  <title>Markdown to HTML</title>
</head>

<body>
  <div class="d-flex justify-content-between mt-2 px-5">
    <h1 class="fs-2 fw-bolder">Markdown to HTML</h1>
    <div class="text-end gap-1">
      <button id="markdown-preview-btn" type="button" class="btn btn-secondary btn-sm">Preview</button>
      <button id="html-preview-btn" type="button" class="btn btn-secondary btn-sm">HTML</button>
      <button id="highlight-btn" type="button" class="btn btn-secondary btn-sm">Highlight: ON</button>
      <button id="download-btn" type="submit" class="btn btn-secondary btn-sm">Download</button>
    </div>
  </div>
  <div class="row px-5">
    <div id="editor-container" class="w-50 px-0" style="height:600px;border:1px solid grey"></div>
    <div id="preview-container" class="w-50 overflow-hidden" style="height:600px;border:1px solid grey"></div>
  </div>

  <script>
    var require = {
      paths: {
        vs: './node_modules/monaco-editor/min/vs'
      }
    };
  </script>
  <script src="./node_modules/monaco-editor/min/vs/loader.js"></script>
  <script src="./node_modules/monaco-editor/min/vs/editor/editor.main.nls.js"></script>
  <script src="./node_modules/monaco-editor/min/vs/editor/editor.main.js"></script>
  <script>
    let mode = "preview" // preview or html
    let highlight = true

    const editorContainer = document.getElementById('editor-container')
    const previewContainer = document.getElementById('preview-container')

    const markdownPreviewBtn = document.getElementById('markdown-preview-btn')
    const htmlPreviewBtn = document.getElementById('html-preview-btn')
    const highlightBtn = document.getElementById('highlight-btn')
    const downloadBtn = document.getElementById('download-btn')

    const defaultCode =
      "# Type sentences\n\n[Recursion](https://recursionist.io)\n\n```\nfunction hello(){\n  return 'hello';\n}\n```"

    const editor = monaco.editor.create(editorContainer, {
      value: defaultCode,
      language: 'markdown',
      minimap: {
        enabled: false,
      },
      lineDecorationsWidth: 5,
      automaticLayout: true
    });

    editor.onDidChangeModelContent(() => {
      renderPreview()
    })

    const renderPreview = () => {
      const editorValue = editor.getValue()
      const data = {
        "markdown": editorValue,
        "highlight": highlight ? "True" : "False"
      }

      fetch("converter.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
      }).then((res) => res.json()).then((data) => {
        // previewを更新
        if (mode === "preview") {
          previewContainer.innerHTML = data.html
        } else if (mode === "html") {
          previewContainer.innerText = data.html
        }

      }).catch(error => {
        console.error('Error:', error)
      });
    }

    markdownPreviewBtn.addEventListener("click", () => {
      if (mode !== "preview") {
        mode = "preview"
        renderPreview()
      }
    })

    htmlPreviewBtn.addEventListener("click", () => {
      if (mode !== "html") {
        mode = "html"
        renderPreview()
      }
    })

    const toggleHighlightBtn = () => {
      highlightBtn.innerText = highlight ? "Highlight: OFF" : "Highlight: ON"
      highlight = !highlight
    }

    highlightBtn.addEventListener("click", () => {
      toggleHighlightBtn()
      renderPreview()
    })

    downloadBtn.addEventListener("click", () => {
      const data = {
        "html": previewContainer.innerHTML
      }

      fetch("download.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify(data)
        })
        .then((res) => res.blob()).then((blob) => {
          const url = window.URL.createObjectURL(blob)
          const a = document.createElement("a")
          a.href = url
          a.download = "markdown.html"
          a.click()
          window.URL.revokeObjectURL(url)
        })
        .catch(error => {
          console.error('Error:', error)
        });
    })

    renderPreview()
  </script>
</body>

</html>