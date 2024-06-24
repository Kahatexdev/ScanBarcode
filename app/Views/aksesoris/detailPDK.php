<?php $this->extend($role . '/layout'); ?>
<?php $this->section('content'); ?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1><?= $title ?></h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item">Tables</li>
        <li class="breadcrumb-item active">Data</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title"></h5>
            <!-- <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to conver to a datatable</p> -->
            <div class="row d-flex">
              <div class="col-6">&nbsp;</div>
              <div class="col-6 d-flex justify-content-end">
                <a href="<?= base_url('aksesoris/dataPO/' . $id_po . '/' . $po) ?>" class="btn btn-outline-dark mx-3"><strong> Ganti PDK</strong></a>

                <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#smallModal"><strong>+ Barcode</strong></button>
              </div>
              <!-- sweetalert -->
              <?php if (session()->getFlashdata('success')) : ?>
                <script>
                  $(document).ready(function() {
                    Swal.fire({
                      icon: 'success',
                      title: 'Success!',
                      text: '<?= session()->getFlashdata('success') ?>',
                    });
                  });
                </script>
              <?php endif; ?>

              <?php if (session()->getFlashdata('error')) : ?>
                <script>
                  $(document).ready(function() {
                    Swal.fire({
                      icon: 'error',
                      title: 'Error!',
                      text: '<?= session()->getFlashdata('error') ?>',
                    });
                  });
                </script>
              <?php endif; ?>
              <!-- end sweetalert -->
              <!-- isi dari modal +PO -->
              <div class="modal fade" id="smallModal" tabindex="-1">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <form action="<?= base_url($role . '/prosesInputBarcode') ?>" method="POST">
                      <div class="modal-header">
                        <h5 class="modal-title"><strong>Input Master Barcode</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group">
                          <label>PDK</label>
                          <input type="hidden" class="form-control" name="id_po" id="id_po" value="<?= $id_po ?>" required readonly>
                          <input type="hidden" class="form-control" name="id_pdk" id="id_pdk" value="<?= $id_pdk ?>" required readonly>
                          <input type="text" class="form-control" name="pdk" id="pdk" value="<?= $pdk ?>" required readonly>
                        </div>
                        <div class="form-group">
                          <label>Barcode Real</label>
                          <input type="text" class="form-control" name="barcode_real" id="barcode_real" required>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div><!--End isi modal +PO -->
            </div><br>

            <!-- Table with stripped rows -->
            <table id="dataTable" class="table datatable">
              <thead style="text-align: center;">
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Barcode</th>
                  <th scope="col">Qty Scan</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody style="text-align: center;">
                <?php
                $no = 1;
                foreach ($detailpdk as $row) : ?>
                  <tr>
                    <th scope="row"><?= $no++; ?></th>
                    <td><?= $row['barcode_real']; ?></td>
                    <td><?= $qty_scan ?></td>
                    <td><a href="<?= base_url($role . '/scanBarcode/' . $row['id_data']) ?>" class="btn btn-info">Scan</a></td>
                  </tr>
                <?php
                endforeach;
                ?>
              </tbody>
            </table>

          </div>
        </div>

      </div>
    </div>
  </section>

</main><!-- End #main -->
<?php $this->endSection(); ?>