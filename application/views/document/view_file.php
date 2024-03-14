<style>
  .action {
    display: flex;
    flex-direction: row;
    justify-content: space-around;
  }
</style>
<div class="main-content">
  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Csv File List</h4>
            </div>

            <?php //print_r($percentage[0]['percentage']);die;
            ?>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                  <?php
                  // Assuming $totalIncome and $userData are available in the view

                  // echo '<p>Total Income: ' . $totalIncome . '</p>';
                  // echo '<p>Total Your Income: ' . $tenPercent . '</p>';

                  ?>
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>ISRC</th>
                      <th>MAIN LABEL</th>
                      <th>SONG NAME</th>
                      <th>ALBUM NAME</th>
                      <th>ARTIST NAME</th>
                      <th>MONTH</th>
                      <th>INCOME</th>
                      <th>YOUR INCOME</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php if (!empty($userData)) { ?>

                      <?php $i = 1; ?>

                      <?php foreach ($userData as $row) { ?>
                        <tr>
                          <td scope="row"><?php echo $i; ?></td>

                          <td>
                            <?php echo $row['isrc'] ?? $row['Isrc'] ?? $row['ISRC'] ?? ''; ?>
                          </td><!--albumname-->

                          <td>
                            <?php echo $row['Main_label'] ?? $row['Main_Label'] ?? $row['main_Label'] ?? $row['MAIN_LABEL'] ?? $row['album_Name'] ?? ''; ?>
                          </td>

                          <td>
                            <?php echo $row['song_name'] ?? $row['song'] ?? $row['SONG_NAME'] ?? $row['Song_Name'] ?? $row['Song_name'] ??  $row['song_Name'] ??  $row['song_Name'] ?? ''; ?>
                          </td> <!--artist name -->

                          <td>
                            <?php echo $row['album_name'] ?? $row['album'] ?? $row['Album_Name'] ?? $row['Album_name'] ?? $row['album_Name'] ?? ''; ?>
                          </td>

                          <td>
                            <?php echo $row['artist_name'] ?? $row['artist'] ?? $row['ARTIST'] ?? $row['Artist_Name'] ?? $row['artist_Name'] ??  $row['Artist_name'] ?? ''; ?>
                          </td><!--main_label-->
                          <td>
                            <?php echo $row['MONTH'] ?? $row['month'] ?? $row['Month'] ?? ''; ?>
                          </td><!--sub_label-->
                          <td>
                            <?php echo $row['income'] ?? $row['INCOME'] ?? $row['Income'] ?? ''; ?>
                          </td><!--income-->

                          <td><?php echo number_format(floatval($row['income'] ?? $row['INCOME'] ?? $row['Income']  ?? '') * 0.10, 5) ?></td> <!--your income-->
                          <!-- <td>Month</td>month -->
                          <td><a class="btn btn-primary" href="<?php echo base_url('csvupload/edit/' . $row['id'] . '/' . $row['table_name']); ?>">Edit</a></td>
                        </tr>
                    <?php $i++;
                      }
                    } else {
                      echo '<tr><td colspan="9">No data found</td></tr>';
                    } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
  function product_status(value, id) {
    $.ajax({
      type: "POST",
      cache: false,
      url: "<?php echo base_url(); ?>Product/status",
      data: {
        id: id,
        status: value
      },
      dataType: 'json',
      success: function(data) {
        location.reload();
      }
    });
  }
</script>