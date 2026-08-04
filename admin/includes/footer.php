 <div class="main-content">
                    <div class="row mt-5">
                        <div class="col text-center text-secondary small">
                            <i class="far fa-copyright me-1"></i> 2026 School ERP · Staff & Payroll Dashboard
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                if (this.getAttribute('href') === '#') e.preventDefault();
                document.querySelectorAll('.sidebar .nav-link').forEach(l => l.classList.remove(
                    'active'));
                this.classList.add('active');
            });
        });
    </script>
</body>

</html>