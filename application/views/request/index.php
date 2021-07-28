<div class="row justify-content-center">
    <div class="col-md-12">
        <?= $this->session->flashdata('msg'); ?>
        <div class="card">
            <div class="card-header bg-white">
                <div class="row">
                    <div class="col d-flex">
                        <h3 class="h5 mb-0 card-title align-self-center">
                            Data <?= $title; ?>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped mb-0 datatable">
                    <thead>
                        <tr>
                            <th width="100">No.</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Di Buat</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($barang as $row) : ?>
                            <tr>
                                <td><?= $no++; ?>.</td>
                                <td><?= $row->kdBarang; ?></td>
                                <td><?= $row->namaBarang; ?></td>
                                <td>Rp. <?= number_format($row->harga, '0', ',', '.'); ?></td>
                                <td><?= $row->nama; ?></td>
                                <td>
                                    <div class="btn-group">
                                    <a href="<?= base_url('request/accept/') . $row->kdBarang ?>" class="btn btn-sm btn-primary">
                                            Accept
                                        </a>
                                        <a href="<?= base_url('request/edit/') . $row->kdBarang ?>" class="btn btn-sm btn-secondary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <?php if (menu_role(['administrator'])) : ?>
                                            <a onclick="return confirm('Yakin ingin hapus data?')" href="<?= base_url('barang/hapus/') . $row->kdBarang ?>" class="btn btn-sm btn-secondary">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>