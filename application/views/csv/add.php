<div class="main-content">
  <section class="section">
    <div class="section-body">
      <div class="col-8">
        <div class="card">
          <div class="card-header">
            <h4>Add Product</h4>
          </div>
          <form method="POST" action="<?php echo base_url('Product/insert');?>" enctype="multipart/form-data">
            <div class="card-body">
              <div class="form-group">
                <label>Product Image</label>
                  <input type="file" name="product_img" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control"></textarea>
              </div>
              <div class="form-group">
                <label>Orginal Cost</label>
                <input type="number" name="orginal_cost" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Cost</label>
                <input type="number" name="cost" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Quantity</label>
                <input type="text" name="qty" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Subscription</label>
                <select class="form-control selectric" name="subscription_product" required>
                  <option label="select">select</option>
                  <option value="1">Yes</option>
                  <option value="0">No</option>
                </select>
              </div>
            </div>
            <div class="card-footer text-right">
              <button class="btn btn-primary mr-1" type="submit" name="save">Submit</button>
              <button class="btn btn-secondary" type="reset">Reset</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>