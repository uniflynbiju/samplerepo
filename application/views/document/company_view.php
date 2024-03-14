<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Data Form</title>
    <style>
        form {
            width: 300px;
            margin: 0 auto;
            padding-top: 15%;
        }

        table {
            margin: 0 auto;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>

    <form method="post" action="<?php echo base_url('csvupload/company_method') ?>">
        <div class="form-group">
            <label for="name">Company Name:</label>
            <input type="text" id="name" class="form-control" name="company_name">
        </div>
        <!-- <input type="submit" name="submit" value="Submit"> -->
        <button type="submit" name="submit" class="btn btn-primary">Submit</a></button>

    </form><br>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Company Name</th>
                <th>Action</th>
            </tr>
            <?php if (!is_null($data) && (is_array($data) || is_object($data))) { ?>
                <?php $i = 1; ?>
                <?php foreach ($data as $row) { ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <?php if (is_array($row) || is_object($row)) { ?>
                            <!-- Check if $row is an array or object before accessing its properties -->
                            <td><?php echo $row->company_name; ?></td>
                            <td>
                                <a class="btn btn-primary" href="<?php echo base_url('csvupload/edit2/' . (isset($row->id) ? $row->id : '')); ?>">Edit</a>
                                <a class="btn btn-danger" href="<?php echo base_url('csvupload/delete/' . (isset($row->id) ? $row->id : '')); ?>">Delete</a>
                            </td>
                        <?php } ?>
                    </tr>
                <?php $i++;
                } ?>
            <?php } else { ?>
                <p>No data available.</p>
            <?php } ?>



            </tbody>
    </table>

</body>

</html>