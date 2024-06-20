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
                  <form action="<?= base_url($role . '/prosesInputCheckBarcode') ?>" method="POST">
                    <div class="form-control">
                      <input type="text" class="form-control" id="barcode_check" name="barcode_check" placeholder="Barcode" autofocus>
                      <input type="hidden" name="barcode_real" id="barcodereal" value="<?= $master['barcode_real'] ?>">
                      <input type="hidden" name="id_data" id="id_data" value="<?= $master['id_data'] ?>">
                      <input type="hidden" name="id_pdk" id="id_pdk" value="<?= $master['id_pdk'] ?>">
                      <input type="text" name="status" id="status" class="d-none">
                    </div>
                  </form>
                </div>
                <div class="row">
                  <h1 id="pesan"></h1>
                </div>
              </div>
            </div>

            <!-- Table with stripped rows -->
            <table id="dataTable" class="table datatable">
              <thead style="text-align: center;">
                <tr>
                  <th scope="col">No</th>
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
                    if ($row['status'] == "Barcode Sesuai") { ?>
                      <td>
                        <font color="green"><?= $row['status']; ?></font>
                      </td>
                    <?php } else { ?>
                      <td>
                        <font color="red"><?= $row['status']; ?></font>
                      </td>
                    <?php } ?>
                    <td><?= $row['barcode_cek']; ?></td>
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

  <script>
    var audio = new Audio("<?= base_url('assets/audio/emergency.mp3') ?>");
    var debounceTimer;

    function periksaBarcodeOtomatis(input) {
      var barcodeCheck = input.value;
      var barcodereal = document.getElementById('barcodereal').value;

      if (debounceTimer) {
        clearTimeout(debounceTimer);
      }

      debounceTimer = setTimeout(function() {
        if (barcodeCheck !== '') {
          if (barcodeCheck === barcodereal) {
            document.getElementById('pesan').innerHTML = "<font color='green' size='12'><b>Barcode Sesuai</b></font>";
            document.getElementById('status').value = "Barcode Sesuai";
          } else {
            document.getElementById('pesan').innerHTML = "<font color='red' size='12'><b>Barcode Tidak Sesuai</b></font>";
            document.getElementById('status').value = "Barcode Tidak Sesuai";
            audio.play();
            setTimeout(function() {
              audio.pause();
              audio.currentTime = 0;
            }, 3000);
          }

          var status = $("#status").val();
          var idData = $("#id_data").val();
          var idPdk = $("#id_pdk").val();
          var url = "<?= base_url($role . '/prosesInputCheckBarcode') ?>";

          $.ajax({
            url: url,
            type: "POST",
            data: {
              id_pdk: idPdk,
              barcode_check: barcodeCheck,
              id_data: idData,
              status: status
            },
            success: function(response) {
              // Optional: handle success response
            },
            error: function(xhr, status, error) {
              // Optional: handle error response
            }
          });

          setTimeout(function() {
            window.location.reload();
          }, 1000);
        }
      }, 300); // Adjust the debounce delay as needed
    }

    document.getElementById('barcode_check').addEventListener('input', function() {
      periksaBarcodeOtomatis(this);
    });
  </script>

</main><!-- End #main -->
<?php $this->endSection(); ?>