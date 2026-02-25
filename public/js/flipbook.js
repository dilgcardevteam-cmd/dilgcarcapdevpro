$(document).ready(function($) {
    // Find all elements with ID flipBook
    $('[id="flipBook"]').each(function() {
        var flipBook = $(this); // Current flipBook element

        // Get the source URL from the element's attribute
        var url = flipBook.attr('source');

        // PDF.js library instance
        var pdfjsLib = window['pdfjs-dist/build/pdf'];

        // Set the path to the PDF.js worker script
        pdfjsLib.GlobalWorkerOptions.workerSrc = '{{ asset("js/libs/pdf.worker.min.js") }}';

        // Load the PDF document
        pdfjsLib.getDocument(url).promise.then(function(pdf) {
            // Total number of pages in the PDF document
            var numPages = pdf.numPages;

            // Counter for rendered pages
            var pagesRendered = 0;

            // Render a specific page of the PDF
            function renderPage(pageNum) {
                pdf.getPage(pageNum).then(function(page) {
                    // Viewport of the PDF page at scale 0.5
                    var viewport = page.getViewport({ scale: 0.5 });

                    // Width and height of the PDF page
                    var pageWidth = viewport.width;
                    var pageHeight = viewport.height;

                    // Container div for the page content
                    var pageDiv = document.createElement('div');
                    pageDiv.className = 'turn-page-wrapper';
                    pageDiv.style.width = pageWidth + 'px';
                    pageDiv.style.height = pageHeight + 'px';
                    flipBook.append(pageDiv);

                    // Canvas element for rendering the page
                    var canvas = document.createElement('canvas');
                    var context = canvas.getContext('2d');
                    canvas.height = pageHeight;
                    canvas.width = pageWidth;
                    pageDiv.appendChild(canvas);

                    // Rendering context for the canvas
                    var renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };

                    // Render the page content into the canvas
                    page.render(renderContext).promise.then(function() {
                        pagesRendered++;

                        // If all pages are rendered, initialize the flipBook
                        if (pagesRendered === numPages) {
                            initializeFlipBook();
                        }
                    }).catch(function(error) {
                        console.error('Error rendering page', error);
                    });
                }).catch(function(error) {
                    console.error('Error fetching page', error);
                });
            }

            // Initialize the flipBook using turn.js library
            function initializeFlipBook() {
                flipBook.turn({
                    width: (flipBook.width() * 1.80)/2,
                    height: flipBook.height()/2,
                    autoCenter: true
                });
            }

            // Loop through each page and render it
            for (var pageNum = 1; pageNum <= numPages; pageNum++) {
                renderPage(pageNum);
            }

        }).catch(function(error) {
            console.error('Error loading PDF', error);
        });
    });
});
