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
            <div class="row">
              <div class="col-12 my-3 d-flex justify-content-end">
                <a href="<?= base_url('aksesoris/dataPDK/' . $master['id_po'] . '/' . $master['id_pdk']) ?>" class="btn btn-outline-primary">
                  Scan Barcode Lain
                </a>
              </div>
            </div>
            <!-- <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to conver to a datatable</p> -->
            <div class="row d-flex">
              <div class="col-6">
                <div class="row">
                  <div class="col-3  d-flex justify-content-end">
                    <h5> No Barcode </h5>
                  </div>
                  <div class="col-6">
                    <h5> : <?= $master['barcode_real'] ?> </h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-3 d-flex justify-content-end">
                    <h6> PO </h6>
                  </div>
                  <div class="col-6">
                    <h6> : <?= $master['po'] ?> </h6>
                  </div>
                </div>
                <div class="row">
                  <div class="col-3 d-flex justify-content-end">
                    <h6> Buyer </h6>
                  </div>
                  <div class="col-6">
                    <h6> : <?= $master['buyer'] ?> </h6>
                  </div>
                </div>
                <div class="row">
                  <div class="col-3 d-flex justify-content-end">
                    <h6> PDK </h6>
                  </div>
                  <div class="col-6">
                    <h6> : <?= $master['pdk'] ?> </h6>
                  </div>
                </div>
                <div class="row">
                  <div class="col-3 d-flex justify-content-end">
                    <h6> No Order </h6>
                  </div>
                  <div class="col-6">
                    <h6> : <?= $master['no_order'] ?> </h6>
                  </div>
                </div>

              </div>
              <div class="col-6 ">
                <div class="row">
                  <form action="<?= base_url($role . '/cekbarcode') ?>" method="post">
                    <div class="form-control">
                      <input type="text" class="form-control" id="barcode_check" name="barcode_check" placeholder="Barcode" oninput="periksaBarcodeOtomatis(this)" autofocus>
                      <input type="text" name="barcode_real" id="barcodereal" value="<?= $master['barcode_real'] ?>">
                      <input type="text" name="id_data" id="id_data" value="<?= $master['id_data'] ?>">
                      <input type="text" name="status" id="status">

                    </div>
                  </form>
                </div>
                <div class="row">
                  <h1 id="pesan">aaa</h1>
                </div>
              </div>
            </div>

            <!-- Table with stripped rows -->
            <table id="dataTable" class="table datatable">
              <thead style="text-align: center;">
                <tr>
                  <th scope="col">Tanggal Scan</th>
                  <th scope="col">Barcode Actual</th>
                  <th scope="col">Status Scan</th>
                  <th scope="col">Barcode scan</th>
                  <th scope="col">Admin</th>
                </tr>
              </thead>
              <tbody style="text-align: center;">
                <?php
                $no = 1;
                foreach ($barcodeData as $row) : ?>
                  <tr>
                    <th scope="row"><?= $no++; ?></th>
                    <td><?= $row['created_at']; ?></td>
                    <td><?= $row['barcode_real']; ?></td>
                    <?php
                    if ($row['status_scan'] == "Barcode sesuai") {
                      $colorFont = "style='color: green'";
                    } else {
                      $colorFont = "style='color: red'";
                    } ?>
                    <td <?= $colorFont ?>><?= $row['status_scan']; ?></td>
                    <td><?= $row['barcode_scan']; ?></td>
                    <td><?= $row['admin']; ?></td>

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

  <script src="<? base_url('assets/js/jquery3-6-0.min.js') ?>"></script>
  <script>
    function periksaBarcodeOtomatis(input) {
      var barcodeCheck = input.value;
      var barcodereal = getElementById('barcodereal').value;
      if (barcodeCheck !== '') {
        if (barcodeCheck === barcodereal) {
          document.getElementById('pesan').innerHTML = "<font color='green' size='12'><b>Barcode sesuai</b></font>";
        } else {
          document.getElementById('pesan').innerHTML = "<font color='green' size='12'><b>Barcode tidak sesuai</b></font>";
        }
      }
    }
  </script>

</main><!-- End #main -->
<?php $this->endSection(); ?>