<style>
  .action{
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

            <form action="<?php echo base_url('Csvupload/insert_doc') ?>" enctype="multipart/form-data" method="post" role="form">
    <div class="container mt-4">
        <h3 class="text-center mb-4">File Upload</h3>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="fileInput" class="form-label">Choose a CSV or Excel File</label>
                    <input type="file" name="file" class="form-control" id="fileInput" aria-describedby="fileHelp" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                    <div id="fileHelp" class="form-text text-muted">Accepted file formats: CSV, Excel</div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="typeSelect" class="form-label">Select Type</label>
                    <select class="form-select" name="type" id="typeSelect">
                        <option selected disabled>Select type</option>
                        <option value="Amazon">Amazon</option>
                        <option value="Airtel">Airtel</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="monthYearInput" class="form-label">Select Month/Year</label>
                    <input type="month" id="monthYearInput" name="month_year" class="form-control">
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <button type="submit" name="submit" class="btn btn-primary">Upload</button>
            </div>
        </div>
    </div>
</form>


            <div class="card-body">
              <div class="table-responsive">
               <!-- views/document/list.php -->

        <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Type</th>
                    <th>File Name</th>                  
                    <th>Month/Year</th>
                    <!-- Add more columns if needed based on your table structure -->
                    <th>View</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
    <?php $counter = 1; ?>
    <?php if (isset($userData) && is_array($userData) && count($userData) > 0): ?>
        <?php foreach ($userData as $row): ?>
            <tr>
                <td><?= $counter++; ?></td>
                <td><?= $row['type']; ?></td>
                <td><?= $row['file_name']; ?></td>
                <td><?= date('M-Y', strtotime($row['month_year'])); ?></td>

                <td><a href="<?= base_url('Csvupload/view_file/' . $row['table_name']); ?>">View</a></td>
                <td><a href="<?= base_url('Csvupload/delete_table/' . $row['table_name']);  ?>" onclick="return confirm('Are you sure you want to delete this table?');">Delete</a></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6">No data available</td>
        </tr>
    <?php endif; ?>
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
  function product_status(value,id){
    $.ajax({
      type: "POST",
      cache: false,
      url: "<?php echo base_url(); ?>Product/status",
      data: {
          id : id, status : value
      },
      dataType: 'json',
      success: function(data) {
        location.reload();
      }
    });
  }
</script>