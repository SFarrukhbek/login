<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="utf-8">
    <title>Почтаи раёсат</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { min-height: 100vh; display: flex; flex-direction: column; }
        .content { flex: 1; }
        .sidebar { min-height: 100vh; display: flex; flex-direction: column; }
        footer { background: #0d6efd; color: white; padding: 10px 0; text-align: center; }
        .active { font-weight: bold; }

        /* Fayl yuklash formasi markazda */
        #uploadForm {
            display: none;
            margin: 50px auto;
            max-width: 500px;
        }
    </style>
</head>
<body>
<header class="bg-primary text-white py-3 px-4 d-flex justify-content-between align-items-center">
    <h4 class="m-0">Хуш омадед</h4>
</header>

<div class="container-fluid content">
    <div class="row">
        <!-- Chap menyu -->
        <div class="col-md-3 col-lg-2 bg-light sidebar p-3 d-flex flex-column">
            <div class="list-group flex-grow-1">
                <?php if(!empty($menu)): ?>
                    <?php foreach($menu as $item): ?>
                        <a href="<?= base_url('index.php/'.$item->link) ?>" 
                           class="list-group-item list-group-item-action <?= ($current_page == $item->link) ? 'active' : '' ?>">
                            <?= $item->title ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>

                <!-- Хабархо link -->
                <a href="<?= base_url('index.php/istori/view/malumotlar') ?>" 
                   class="list-group-item list-group-item-action">
                    📜 Хабархо
                </a>

                <!-- Fayl yuklash tugmasi Хабархо bilan birhil ko‘rinishi uchun -->
                <a href="javascript:void(0);" 
                   id="showFormBtn" 
                   class="list-group-item list-group-item-action text-success fw-bold">
                    📤 Файл юклаш
                </a>
            </div>
        </div>

        <!-- Asosiy kontent -->
        <div class="col-md-9 p-3 position-relative">
            <!-- Fayl yuklash formasi -->
            <div id="uploadForm" class="card p-3 shadow">
                <form id="fileForm" action="<?= base_url('index.php/malumotlar/upload_file') ?>" method="post" enctype="multipart/form-data">
    <input type="file" name="file" id="fileInput" style="display:none;">
    <input type="hidden" name="from_page" value="malumotlar">

    <select name="destination" id="destination" class="form-select mb-2" required>
        <option value="">Ба кадом шӯъба</option>
        <option value="aloqa">Раёсат ғойбона</option>
        <option value="bosh_sahifa">Таҳсили сифат</option>
        <option value="rayosati_talim">Раёсати талим</option>
        <option value="hisobot">Маркази тест</option>
        <option value="sozlamalar">Канслария</option>
        <option value="all">Барои ҳама</option>
    </select>

    <textarea name="textariya" class="form-control mb-2" rows="3" placeholder="Изоҳ ёдгоред..." required></textarea>

    <button type="button" id="fileBtn" class="btn btn-secondary">Интихоби файл</button>
    <button type="submit" id="submitBtn" class="btn btn-primary mt-2">Фиристода</button>
</form>
                <p id="fileName"></p>
            </div>

            <!-- Xabarlar -->
            <?php if($this->session->flashdata('info')): ?> 
                <div class="alert alert-success mt-3"> 
                    <?= $this->session->flashdata('info'); ?> 
                </div> 
            <?php endif; ?>

            <!-- Fayllar ro'yxati -->
            <hr>
            <?php if (!empty($files)): ?>
                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Аз кӣ</th>
                                <th>Эзоҳ</th>
                                <th>Файл</th>
                                <th>Сана</th>
                                <th>Амалиёт</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($files as $f): ?>
                                <tr>
                                    <td><?= $f->uploaded_by ?></td>
                                    <td><?= !empty($f->text) ? $f->text : '-' ?></td>
                                    <td>
                                        <?php if (!empty($f->file_name)): ?>
                                            <a href="<?= base_url('uploads/' . $f->destination . '/' . $f->file_name) ?>" target="_blank">
                                                📎 <?= $f->file_name ?>
                                            </a>
                                        <?php else: ?>
                                            –
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $f->uploaded_at ?></td>
                                    <td>
                                       <a href="<?= base_url('index.php/malumotlar/delete/' . $f->id) ?>" class="btn btn-danger btn-sm">
                                          🗑 Хориҷ
                                       </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-muted">📂 Ҳоло ҳеҷ файл борнашудааст</p>
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
const showFormBtn = document.getElementById('showFormBtn');
const uploadForm = document.getElementById('uploadForm');

// Formani ko'rsatish / yashirish
showFormBtn.addEventListener('click', () => {
    uploadForm.style.display = (uploadForm.style.display === 'block') ? 'none' : 'block';
    if(uploadForm.style.display === 'block'){
        uploadForm.scrollIntoView({behavior: 'smooth'});
    }
});

// Fayl tanlash
fileBtn.addEventListener('click', () => fileInput.click());

fileInput.addEventListener('change', function() {
    if(this.files.length > 0){
        fileNameElem.innerHTML = `<span class="text-primary">${this.files[0].name}</span>`;
        submitBtn.style.display = 'inline-block';
    }
});

// Formani yuborishdan oldin fayl borligini tekshirish
fileForm.addEventListener('submit', function(e){
    
    }
);
</script>

<footer class="mt-auto">
    <a href="<?= base_url('index.php/login/logout') ?>" class="btn btn-danger">Баромад</a>
</footer>
</body>
</html>
