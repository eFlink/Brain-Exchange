<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        #container {
            display: flex;
        }
        #sidebar {
            width: 25%;
            min-width: 200px;
        }
        .main-content {
            width: 75%;
            min-width: 400px;
            margin-left: 2%;
            margin-right: 2%;
        }
    </style>
</head>
<body>
    <?= view('layout/header') ?>
    <div id="container">
      <?= view('layout/sidebar', ['courses' => $courses]) ?>
      <div class="main-content mt-5">
        <h2>Create Post</h2>

        <?php echo form_open_multipart(base_url().'home/check_post'); ?>
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="title" required>
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" rows="5" required></textarea>
          </div>
          <div class="form-group">
            <label for="course_id">Course</label>
            <select class="form-control" name="course_id" id="course_id" required>
              <option value="">Select a course</option>
                <?php foreach ($courses as $course): ?>
                    <option value="<?= $course['course_id'] ?>"><?= $course['course_name'] ?></option>
                <?php endforeach; ?>
            </select>
          </div>
<div class="form-group">
  <label for="images">Images</label>
  <div id="drop-zone" style="border: 2px dashed #ccc; padding: 20px; text-align: center;">
    <p>Drag &amp; Drop your images here or click to select files.</p>
    <input type="file" class="form-control" name="images[]" id="images" multiple style="display: none;">
  </div>
  <div id="preview" style="display: flex; flex-wrap: wrap; gap: 10px;"></div>
</div>
          <button type="submit" class="btn btn-primary mt-3">Submit</button>
        <?php echo form_close(); ?>
      </div>
    </div>
    <?= view('layout/footer') ?>

<script>
  const dropZone = document.getElementById('drop-zone');
  const fileInput = document.getElementById('images');
  const preview = document.getElementById('preview');

  dropZone.addEventListener('click', () => {
    fileInput.click();
  });

  fileInput.addEventListener('change', () => {
    handleFiles(fileInput.files);
  });

  dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.style.backgroundColor = '#eee';
  });

  dropZone.addEventListener('dragleave', () => {
    dropZone.style.backgroundColor = '';
  });

  dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.style.backgroundColor = '';
    handleFiles(e.dataTransfer.files);
  });

  function handleFiles(files) {
    preview.innerHTML = ''; // Clear the preview area
    for (const file of files) {
      if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = (e) => {
          const img = new Image();
          img.src = e.target.result;
          img.width = 200;
          preview.appendChild(img);
        };
        reader.readAsDataURL(file);
      } else {
        alert('Please select only image files.');
        break;
      }
    }
  }
</script>

</body>
