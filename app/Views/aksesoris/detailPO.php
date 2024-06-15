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
                <a href="<?= base_url('aksesoris')?>" class="btn btn-outline-dark mx-3" ><strong> Ganti PO</strong></a> 
                <button type="button" class="btn btn-outline-dark mx-2" data-bs-toggle="modal" data-bs-target="#smallModal"><strong>+ PDK</strong></button>
              </div>
              <!-- isi dari modal +PO -->
              <div class="modal fade" id="smallModal" tabindex="-1">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <form action="<?= base_url($role . '/prosesInputPDK') ?>" method="POST">
                      <div class="modal-header">
                        <h5 class="modal-title"><strong>Input PDK</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group">
                          <label>PO</label>
                          <input type="text" class="form-control text-primary text-bold" name="id_po" id="id_po" value="<?= $id_po ?>" required readonly>
                          <input type="text" class="form-control mt-2 text-primary text-bold" name="po" id="po" value="<?= $no_po ?>" required readonly>
                        </div>
                        <div class="form-group">
                          <label>PDK</label>
                          <input type="text" class="form-control" name="pdk" id="pdk" required>
                        </div>
                        <div class="form-group">
                          <label>No Order</label>
                          <input type="text" class="form-control" name="no_order" id="no_order" required>
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
                  <th scope="col">PDK</th>
                  <th scope="col">No Order</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody style="text-align: center;">
                <?php 
                  $no = 1;
                  foreach ($detailpo as $row) : ?>
                    <tr>
                        <th scope="row"><?= $no++; ?></th>
                        <td><?= $row['pdk']; ?></td>
                        <td><?= $row['no_order']; ?></td>
                        <td><a href="<?= base_url($role . '/dataPDK/' .$id_po .'/'. $row['id_pdk']) ?>" class="btn btn-info text-white">Detail</a></td>
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