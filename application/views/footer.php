<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.clickable-row').forEach(function (row) {
                    row.addEventListener('click', function () {
                        window.location = this.dataset.href;
                    });
                });
            });
        </script>
    </body>
</html>
