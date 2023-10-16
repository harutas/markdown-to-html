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
      <button id="preview" type="button" class="btn btn-secondary btn-sm">Preview</button>
      <button id="html-preview" type="button" class="btn btn-secondary btn-sm">HTML</button>
      <button id="highlight" type="button" class="btn btn-secondary btn-sm">Highlight: ON</button>
      <button id="download" type="submit" class="btn btn-secondary btn-sm">Download</button>
    </div>
  </div>
  <div class="row px-5">
    <div id="editor-container" class="col px-0" style="height:600px;border:1px solid grey"></div>
    <div id="editor-preview" class="col overflow-hidden" style="height:600px;border:1px solid grey"></div>
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
    const defaultCode =
      '# Type sentences\n\n[Recursion](https://recursionist.io)\n\n```\nfunction hello(){\n  return "hello";\n}\n```';
    const editor = monaco.editor.create(document.getElementById('editor-container'), {
      value: defaultCode,
      language: 'markdown',
      minimap: {
        enabled: false,
      },
      lineDecorationsWidth: 5,
    });
  </script>
</body>

</html>