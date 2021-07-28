<?php if (menu_role(['sales'])) : ?>
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col d-flex">
                            <h3 class="h5 mb-0 card-title align-self-center">
                                Tambah Data
                            </h3>
                        </div>
                        <div class="col text-right">
                            <a href="<?= base_url('kunjungan') ?>" class="btn btn-sm btn-secondary">
                                <i class="fas fa-chevron-left"></i> Batal
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?= form_open(); ?>
                    <div class="form-group">
                        <label for="nama_cv">Nama Perusahaan</label>
                        <input value="<?= set_value('nama_cv'); ?>" type="text" id="nama_cv" name="nama_cv" class="form-control" placeholder="Nama Perusahaan. . .">
                        <?= form_error('nama_cv'); ?>
                    </div>
                    <div class="form-group">
                        <label for="nama_client">Nama Client</label>
                        <input value="<?= set_value('nama_client'); ?>" type="text" id="nama_client" name="nama_client" class="form-control" placeholder="Nama Client. . .">
                        <?= form_error('nama_client'); ?>
                    </div>
                    <div class="form-group">
                        <label for="no_hp">No Telephone</label>
                        <input value="<?= set_value('no_hp'); ?>" type="text" id="no_hp" name="no_hp" class="form-control" placeholder="No Telephone. . .">
                        <?= form_error('no_hp'); ?>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input value="<?= set_value('alamat'); ?>" type="text" id="alamat" name="alamat" class="form-control" placeholder="Alamat. . .">
                        <?= form_error('alamat'); ?>
                    </div>
                    <div class="form-group">
                        <label for="nama_sales">Nama Sales</label>
                        <input type="text" name="nama_sales" value="<?= userdata()->nama; ?>" id="nama_sales" readonly class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tgl_kunjungan">Tanggal Kunjungan</label>
                        <input type="text" name="tgl_kunjungan" value="<?= date('d/m/Y') ?>" id="tgl_kunjungan" readonly class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="jam_kunjungan">Jam Kunjungan</label>
                        <input type="text" name="jam_kunjungan" value="<?= date('H:i:s') ?>" id="jam_kunjungan" readonly class="form-control">
                    </div>

                    <button type="submit" class="btn btn-block btn-primary">Simpan</button>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>