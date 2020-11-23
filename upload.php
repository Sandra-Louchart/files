<?php

if (!empty($_FILES['test']['name'][0])){
    $uploadDir = 'uploads/';
    $maxSize = 1000000;
    $validExt = ['jpg', 'gif', 'png'];
    $errors = [];

    $files = $_FILES['test'];

    foreach($files['name'] as $i => $file_name){

        $files_error = $files['error'][$i];
        $files_size = $files['size'][$i];
        $files_tmp = $files['tmp_name'][$i];

        $files_ext = explode('.', strtolower($files['name'][$i]));
        $files_ext = end($files_ext);

        if (in_array($files_ext, $validExt)){

            if ($files_error === 0){

                if(filesize($files_tmp) < $maxSize){

                    $file_new_name = uniqid(' ', true).'.'.$files_ext;
                    $file_destination = $uploadDir.$file_new_name;
                    move_uploaded_file($files_tmp, $file_destination);

                } else {
                    $error[] = 'Le fichier '. $files['name'][$i] . ' ne peut excéder la taille de '. $maxSize .' octets';
                }
            } else {
                $error[] = 'Le fichier n\'est pas bien téléchargé, veuillez suivre les informations';
            }
        } else {
            $error[] = 'Le fichier ne possède pas la bonne extension (.jpg, .jpeg, .jpeg, .gif, .png)';
        }
    }
    if (!empty($error)){
        echo print_r($error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
<h1>Formulaire d'envoie de fichier</h1>
<form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <h2>Documents upload</h2>
        <p></p><strong>Note:</strong> Seulement .jpg, .jpeg, .jpeg, .gif, .png are authorized until 1 Mo.</p>
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
        <input type="file" name="test[]" multiple="multiple"> <br>
        <input type="submit" name ="submit">
    </div>
</form>

<?php
$files = new FilesystemIterator(__DIR__.'/uploads', FilesystemIterator::SKIP_DOTS);

foreach ($files as $file) { ?>
    <figure>
        <img src="uploads/<?= $file->getFilename() ?>"
             alt="image <?= $file->getFilename() ?>">
    </figure>
<?php  }
?>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
