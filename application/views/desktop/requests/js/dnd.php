<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 16.12.2017
 * Time: 17:09
 */
?>


<script>
    $(document).ready(function() {
        var dropZone = document.getElementById('dndArea');

        function showDropZone() {
            dropZone.style.display = "block";
        }
        function hideDropZone() {
            dropZone.style.display = "none";
        }

        function allowDrag(e) {
            if (true) {  // Test that the item being dragged is a valid one
                e.dataTransfer.dropEffect = 'copy';
                e.preventDefault();
            }
        }

        function handleDrop(event) {
            event.preventDefault();
            hideDropZone();

            $("#fileElem").removeClass("active");
            $("#filelist").removeClass("active");
            $(".js-dnd-area").find("#fileElem").addClass("active");
            $(".js-dnd-area").find("#filelist").addClass("active");
            //$(".js-dnd-area").find("#fileElem").click();


            event.preventDefault();

            var files = event.dataTransfer.files;

            handleFiles(files);
        }

// 1
        window.addEventListener('dragenter', function(e) {
            showDropZone();
        });

// 2
        dropZone.addEventListener('dragenter', allowDrag);
        dropZone.addEventListener('dragover', allowDrag);

// 3
        dropZone.addEventListener('dragleave', function(e) {
            hideDropZone();
        });

// 4
        dropZone.addEventListener('drop', handleDrop);
    });
</script>