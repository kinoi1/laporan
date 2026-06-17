<!DOCTYPE html>
<html>
<body>

<div class="container">
    <iframe
        id="pdfViewer"
        src="{{ asset('storage/' . $agenda->attachment) }}"
        width="100%"
        height="800">
    </iframe>

    <button onclick="printPdf()">
        Cetak PDF
    </button>
</div>

<script>
function printPdf() {
    const iframe = document.getElementById('pdfViewer');
    iframe.contentWindow.print();
}
</script>
</body>
</html>