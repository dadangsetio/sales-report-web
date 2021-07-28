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
                    <div class="col text-right">
                        <?php if (menu_role(['sales'])) : ?>
                            <a href="<?= base_url('kunjungan/add') ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i> Tambah Data
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped mb-0 datatable">
                    <thead>
                        <tr>
                            <th style="width:5%;">No.</th>
                            <th>Nama Perusahaan</th>
                            <th>Nama Client</th>
                            <th>No Telephone</th>
                            <th>Alamat</th>
                            <th>Nama Sales</th>
                            <th>Tanggal Kunjungan</th>
                            <th>Jam Kunjungan</th>
                            <?php if (menu_role(['administrator'])) : ?>
                                <th>Hapus</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($kunjungan as $row) : ?>
                            <tr>
                                <td><?= $no++; ?>.</td>
                                <td><?= $row->nama_cv; ?></td>
                                <td><?= $row->nama_client; ?></td>
                                <td><?= $row->no_hp; ?></td>
                                <td><?= $row->alamat; ?></td>
                                <td><?= $row->nama_sales; ?></td>
                                <td><?= $row->tgl_kunjungan; ?></td>
                                <td><?= $row->jam_kunjungan; ?></td>
                                <td>
                                    <div class="btn-group">
                                        <?php if (menu_role(['administrator'])) : ?>
                                            <a onclick="return confirm('Yakin ingin hapus data?')" href="<?= base_url('kunjungan/hapus/') . $row->idkunjungan ?>" class="btn btn-sm btn-secondary">
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