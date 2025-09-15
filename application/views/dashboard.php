<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Почтаи раёсат</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { min-height: 100vh; display: flex; flex-direction: column; }
        .content { flex: 1; }
        .sidebar { min-height: 100%; }
        footer { background: #0d6efd; color: white; padding: 10px 0; text-align: center; }
    </style>
</head>
<body>
      <header class="bg-primary text-white py-3 px-4 d-flex justify-content-between align-items-center">
   <h4 class="m-0">Хуш омадед</h4>
</header>
<div class="container-fluid content">
    <div class="row">
        <!-- Chapdagi menyu -->
        <div class="col-md-3 col-lg-2 bg-light sidebar p-3">
            <h5 class="mb-3">Хабархо</h5>
            <div class="list-group">
                <?php foreach($menu as $item): ?>
                    <a href="<?= base_url('index.php/'.$item->link) ?>" class="list-group-item list-group-item-action">
                        <?= $item->title ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-md-9 p-3">
            <center>
            <form id="fileForm" action="<?= base_url('index.php/dashboard/upload_file') ?>" method="post" enctype="multipart/form-data">
    <input type="file" name="file" id="fileInput" style="display:none;" required>

    <!-- Fayl qaysi oynadan yuborilganini belgilash -->
    <input type="hidden" name="from_page" value="dashboard">

    <!-- Sahifa tanlash -->
    <select name="destination" id="destination" class="form-select mb-2" required>
        <option value="">Ба кадом шӯъба</option>
        <option value="all">Барои ҳама</option>
        <option value="rayosati_talim">Rayosati Talim</option>
        <option value="bosh_sahifa">Bosh Sahifa</option>
        <option value="malumotlar">Malumotlar</option>
        <option value="hisobot">Hisobot</option>
        <option value="sozlamalar">Sozlamalar</option>
        <option value="aloqa">Aloqa</option>
    </select>

    <button type="button" id="fileBtn" class="btn btn-secondary">Интихоби файл</button>
    <button type="submit" id="submitBtn" class="btn btn-primary mt-2" style="display:none;">Фиристодан</button>
</form>


            <p id="fileName"></p>
            </center>

            <?php if($this->session->flashdata('info')): ?> 
                <div class="alert alert-success mt-2"> 
                    <?= $this->session->flashdata('info'); ?> 
                </div> 
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
const fileInput = document.getElementById('fileInput');
const fileBtn = document.getElementById('fileBtn');
const submitBtn = document.getElementById('submitBtn');
const fileNameElem = document.getElementById('fileName');
const fileForm = document.getElementById('fileForm');

fileBtn.addEventListener('click', () => fileInput.click());

fileInput.addEventListener('change', function() {
    if(this.files.length > 0){
        let fileName = this.files[0].name;
        fileNameElem.innerHTML = `<span class="text-primary">${fileName}</span>`;
        submitBtn.style.display = 'inline-block';
    }
});

// Fayl tanlanmasa yuborilmasligi
fileForm.addEventListener('submit', function(e){
    if(fileInput.files.length === 0){
        alert("❌ Iltimos, fayl tanlang!");
        e.preventDefault();
    }
});
</script>

<!-- Footer -->
<footer>
    <a href="<?= base_url('index.php/login/logout') ?>" class="btn btn-danger">Баромад</a>
</footer>
</body>
</html>
