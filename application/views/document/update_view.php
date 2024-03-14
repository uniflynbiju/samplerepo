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

    <form method="post" action="<?php echo base_url('csvupload/update') ?>">
        <!-- <h1>Update Form</h1> -->
        <?php foreach ($data as $row) { ?>
    <div class="form-group">
        <label for="name">Csv file update:</label>
        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
        <input type="hidden" name="table_name" value="<?php echo $row['table_name'] ?>">

        <?php if (!empty($row['isrc']) || !empty($row['Isrc']) || !empty($row['ISRC'])) : ?>
            <input type="text" class="form-control" name="isrc" value="<?php echo $row['isrc'] ?? $row['Isrc'] ?? $row['ISRC']; ?>">
        <?php endif; ?>

        <?php if (!empty($row['Main_Label']) || !empty($row['main_Label']) || !empty($row['MAIN_LABEL'])) : ?>
            <input type="text" class="form-control" name="Main_Label" value="<?php echo $row['Main_Label'] ?? $row['main_Label'] ?? $row['MAIN_LABEL']; ?>">
        <?php endif; ?>

        <?php if (!empty($row['song_name']) || !empty($row['song']) || !empty($row['SONG_NAME']) || !empty($row['Song_Name']) || !empty($row['Song_name']) || !empty($row['song_Name'])) : ?>
            <input type="text" class="form-control" name="song_name" value="<?php echo $row['song_name'] ?? $row['song'] ?? $row['SONG_NAME'] ?? $row['Song_Name'] ?? $row['Song_name'] ?? $row['song_Name']; ?>">
        <?php endif; ?>

        <?php if (!empty($row['album_name']) || !empty($row['album']) || !empty($row['Album_Name']) || !empty($row['Album_name']) || !empty($row['album_Name'])) : ?>
            <input type="text" class="form-control" name="album_name" value="<?php echo $row['album_name'] ?? $row['album'] ?? $row['Album_Name'] ?? $row['Album_name'] ?? $row['album_Name']; ?>">
        <?php endif; ?>

        <?php if (!empty($row['artist_name']) || !empty($row['artist']) || !empty($row['ARTIST']) || !empty($row['Artist_Name']) || !empty($row['artist_Name']) || !empty($row['Artist_name'])) : ?>
            <input type="text" class="form-control" name="artist_name" value="<?php echo $row['artist_name'] ?? $row['artist'] ?? $row['ARTIST'] ?? $row['Artist_Name'] ?? $row['artist_Name'] ?? $row['Artist_name']; ?>">
        <?php endif; ?>

        <?php if (!empty($row['MONTH']) || !empty($row['month']) || !empty($row['Month'])) : ?>
            <input type="text" class="form-control" name="month" value="<?php echo $row['MONTH'] ?? $row['month'] ?? $row['Month']; ?>">
        <?php endif; ?>

        <?php if (!empty($row['income']) || !empty($row['INCOME']) || !empty($row['Income'])) : ?>
            <input type="text" class="form-control" name="income" value="<?php echo $row['income'] ?? $row['INCOME'] ?? $row['Income']; ?>">
        <?php endif; ?>
    </div>
<?php } ?>

        <button type="submit" name="submit" class="btn btn-primary">submit
        </button>

    </form>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>