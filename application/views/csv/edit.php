<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Add Product</h4>
                    </div>
                    <?php foreach ($product as $value) {?>
                    <form method="POST" action="<?php echo base_url('Product/update'); ?>" enctype="multipart/form-data">
                        <div class="card-body">
                            <input type="hidden" name="edit_id" value="<?php echo $value['id']; ?>">
                            <img src="<?php echo base_url() . $value['images']; ?>" width="200px" />
                            <div class="form-group">
                                <label>Product Image</label>
                                <input type="hidden" name="product_img_db" value="<?php echo $value['images']; ?>">
                                <input type="file" name="product_img" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="<?php echo $value['name']; ?>"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description"
                                    class="form-control"><?php echo $value['description']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Orginal Cost</label>
                                <input type="number" name="orginal_cost" class="form-control"
                                    value="<?php echo $value['orginal_cost']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Cost</label>
                                <input type="number" name="cost" class="form-control"
                                    value="<?php echo $value['cost']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="text" name="qty" class="form-control" value="<?php echo $value['qty']; ?>"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Subscription</label>
                                <select class="form-control selectric" name="subscription_product" required>
                                    <option label="select">select</option>
                                    <option value="1" <?php if ($value['subscription_product'] == 1) {echo "selected";}?>>
                                        Yes</option>
                                    <option value="0" <?php if ($value['subscription_product'] == 0) {echo "selected";}?>>
                                        No</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1" type="submit" name="save">Submit</button>
                            <button class="btn btn-secondary" type="reset">Reset</button>
                        </div>
                    </form>
                    <?php }?>
                </div>
            </div>
        </div>
    </section>
</div>