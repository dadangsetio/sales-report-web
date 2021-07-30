</div>
</main>
<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; <?= date('Y') ?> &middot; Fershoft</div>
        </div>
    </div>
</footer>
</div>
</div>


<!-- logoutModal -->
<div id="logoutModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Logout?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-center">
                Yakin ingin logout?
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <a href="<?= base_url('logout') ?>" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</div>
<!-- ./logoutModal -->

<script src="<?= base_url('assets/') ?>js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- Datatables -->
<script src="<?= base_url(); ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- Daterangepicker -->
<script src="<?= base_url(); ?>assets/vendor/moment/moment.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/daterangepicker/daterangepicker.js"></script>
<!-- Custom JS -->
<script src="<?= base_url('assets/') ?>js/scripts.js"></script>
<!-- Sweetalert2 -->
<script src="<?= base_url(); ?>assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>

<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<?= $this->session->flashdata('pesan'); ?>

<script type="text/javascript">
    $(function() {
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass('selected').html(fileName);
        });

        // Date rang

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#tangal').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        }

        $('#tanggal').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Hari ini': [moment(), moment()],
                'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '7 hari terakhir': [moment().subtract(6, 'days'), moment()],
                '30 hari terakhir': [moment().subtract(29, 'days'), moment()],
                'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
                'Bulan lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Tahun ini': [moment().startOf('year'), moment().endOf('year')],
                'Tahun lalu': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
            }
        }, cb);

        cb(start, end);

        $('#tgl_kunjungan').datepicker({
            format: 'mm/dd/yyyy',
            startDate: '-3d'
        });
        $('#tgl_kunjungan').val(start.format('YYYY-MM-DD'));

        $('#jam_kunjungan').timepicker({
            uiLibrary: 'bootstrap4'
        });

        // Bootstrap
        $('[data-toggle="tooltip"]').tooltip();

        $('#search-only-datatable').DataTable({
            dom: "<'row'<'col-md-4 col-lg-2'f><'col-md-4'><'col-md-4 col-lg-6 text-center'p>>" +
                "<'row mt-2'<'col-md-12 overflow-y h-25'tr>>",
            ordering: false,
            info: false,
        });

        var table = $('.datatable').DataTable({
            buttons: ['copy', 'csv', 'print', 'excel'],
            dom: "<'row px-2 px-md-4 pt-2'<'col-md-3'l><'col-md-5 text-center'B><'col-md-4'f>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'row px-2 px-md-4 py-3'<'col-md-5'i><'col-md-7'p>>",
            lengthMenu: [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, "All"]
            ],
            columnDefs: [{
                targets: -1,
                orderable: false,
                searchable: false
            }]
        });

        table.buttons().container().appendTo('#dataTable_wrapper .col-md-5:eq(0)');
    });
</script>
</body>

</html>