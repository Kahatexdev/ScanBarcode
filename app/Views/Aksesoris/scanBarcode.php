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
                  <form action="<?= base_url($role . '/prosesInputCheckBarcode') ?>" method="POST">
                    <div class="form-control">
                      <input type="text" class="form-control" id="barcode_check" name="barcode_check" placeholder="Barcode" oninput="periksaBarcodeOtomatis(this)" autofocus>
                      <input type="hidden" name="barcode_real" id="barcodereal" value="<?= $master['barcode_real'] ?>">
                      <input type="hidden" name="id_data" id="id_data" value="<?= $master['id_data'] ?>">
                      <input type="text" name="barcode_input" id="barcode_input">
                      <input type="hidden" name="status" id="status">

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
    // variabel audio
    var audio = new Audio("<?= base_url('assets/audio/emergency.mp3') ?>");
    // Timer untuk menunggu scanner selesai memberikan data
    var typingTimer;
    // Timeout setelah 1 detik dari input terakhir
    var doneTypingInterval = 1000;

    function periksaBarcodeOtomatis(input) {
      // Menghapus timer sebelumnya
      clearTimeout(typingTimer);
      // 
      var barcodeCheck = input.value;
      var barcodereal = document.getElementById('barcodereal').value;
      // 
      if (barcodeCheck) {
        typingTimer = setTimeout(function() {
          simpanBarcodeKeDatabase(barcodeCheck); // Panggil fungsi untuk menyimpan barcode ke database
        }, doneTypingInterval);
      }


      document.getElementById('barcode_input').value = barcodeCheck;
      if (barcodeCheck !== '') {
        if (barcodeCheck === barcodereal) {
          document.getElementById('pesan').innerHTML = "<font color='green' size='12'><b>Barcode Sesuai</b></font>";
          document.getElementById('status').value = "Barcode Sesuai";

          // audio tidak di jalankan
          audio.pause();
        } else {
          document.getElementById('pesan').innerHTML = "<font color='red' size='12'><b>Barcode Tidak Sesuai</b></font>";
          document.getElementById('status').value = "Barcode Tidak Sesuai";

          // play audio
          audio.play();

          // Hentikan audio setelah 3 detik
          setTimeout(function() {
            audio.pause();
            audio.currentTime = 0; // Ulangi audio dari awal jika dimainkan lagi
          }, 3000); // 3000 milidetik = 3 detik
        }

        function simpanBarcodeKeDatabase(barcode) {
          var status = $("#status").val();
          var idData = $("#id_data").val();
          // barocde input berisi data dari kolom scan (barcode check)
          var barcodeInput = $("#barcode_input").val();
          var url = "<?= base_url($role . '/prosesInputCheckBarcode') ?>";
          if (barcodeInput !== '') {
            $.ajax({
              url: url,
              type: "POST",
              data: {
                barcode_check: barcodeInput,
                id_data: idData,
                status: status
              },
            }).done(function(response) {
              // Clear input field after successful submission
              $("#barcodeCheck").val("");
              $("#status").val("");
            }).fail(function(xhr, status, error) {
              // Handle error jika ada
              console.error(xhr.responseText);
            });
          }
        }
      }
    }
  </script>

</main><!-- End #main -->
<?php $this->endSection(); ?>