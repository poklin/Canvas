<style type="text/css">
    .editor-toolbar.fullscreen, .editor-preview-side, .CodeMirror-fullscreen {
        z-index: 12;
    }
    .editor-toolbar.fullscreen {
        top: 70px;
    }
    .editor-preview-side, .CodeMirror-fullscreen {
        top: 120px;
    }

    .CodeMirror {
        height: 500px;
    }
</style>
<div id="guide" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Markdown guide</h4>
            </div>
            <div class="modal-body">
                <h4>Emphasis</h4>
                <pre>**<strong>bold</strong>**
*<em>italics</em>*
~~<strike>strikethrough</strike>~~</pre>
                <h4>Headers</h4>
                <pre># Big header
## Medium header
### Small header
#### Tiny header</pre>
                <h4>Lists</h4>
                <pre>* Generic list item
* Generic list item
* Generic list item

1. Numbered list item
2. Numbered list item
3. Numbered list item</pre>
                <h4>Links</h4>
                <pre>[Text to display](http://www.example.com)</pre>
                <h4>Quotes</h4>
                <pre>&gt; This is a quote.
&gt; It can span multiple lines!</pre>
                <h4>Images &nbsp;
                    <small>Need to upload an image? <a href="http://imgur.com/" target="_blank">Imgur</a> has a great
                        interface.
                    </small>
                </h4>
                <pre>![](http://www.example.com/image.jpg)</pre>
                <h4>Tables</h4>
                <pre>| Column 1 | Column 2 | Column 3 |
| -------- | -------- | -------- |
| John     | Doe      | Male     |
| Mary     | Smith    | Female   |

<em>Or without aligning the columns...</em>

| Column 1 | Column 2 | Column 3 |
| -------- | -------- | -------- |
| John | Doe | Male |
| Mary | Smith | Female |
</pre>
                <h4>Displaying code</h4>
                <pre>`var example = "hello!";`

<em>Or spanning multiple lines...</em>

```
var example = "hello!";
alert(example);
```</pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var toggleGuide = function () {
            $('#guide').modal('show');
        }
        var simplemde = new SimpleMDE({
            element: document.getElementById("editor"),
            toolbar: [
                "bold", "italic", "heading", "|",
                "quote", "unordered-list", "ordered-list", "|",
                "link", "image", "|",
                "preview", "side-by-side", "fullscreen", "|",
                {
                    name: "guide",
                    action: toggleGuide,
                    className: "fa fa-question-circle",
                    title: "Markdown Guide",
                }
            ]
        });
    });
</script>